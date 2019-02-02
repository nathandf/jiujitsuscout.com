<?php

namespace Controllers;

use \Core\Controller;

class QuickBoi extends Controller
{
    public function indexAction()
	{
		$db = $this->load( "dao" );
		$input = $this->load( "input" );
		$inputValidator = $this->load( "input-validator" );
		$quickBoi = $this->load( "quick-boi" );

		$quickBoi->setApplicationNamespace( "App" )
			->setEntityNamespace( "Model" )
			->setRepositoryNamespace( "Model\Services" )
			->setMapperNamespace( "Model\Mappers" );

		if ( $input->exists() && $inputValidator->validate(
				$input,
				[
					"token" => [
						"required" => true,
						"equals-hidden" => $this->session->getSession( "csrf-token" )
					],
					"model_name" => [
						"required" => true
					]
				],
				"quick_boi"
			)
		) {
            $property_indicies = $input->get( "property_indicies" );
            if ( is_array( $property_indicies ) ) {
                foreach ( $property_indicies as $index ) {
                    $quickBoi->addEntityPropery( $input->get( "property_row_{$index}" ) );
                }
            }

            vdumpd($quickBoi->getEntityProp());

            die();

			$quickBoi->buildModel( $input->get( "model_name" ) );

			$this->session->addFlashMessage( "Model successfully created: " . $input->get( "model_name" ) );
			$this->session->setFlashMessages();

			$this->view->redirect( "quick-boi/" );
		}

		$this->view->assign( "csrf_token", $this->session->generateCSRFToken() );
		$this->view->assign( "flash_messages", $this->session->getFlashMessages() );

		$this->view->setTemplate( "model-builder.tpl" );
		$this->view->render( "App/Views/Home.php" );

	}
}
