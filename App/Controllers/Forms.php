<?php

namespace Controllers;

use \Core\Controller;

class Forms extends Controller
{
	public function indexAction()
	{
		if ( !$this->issetParam( "id" ) || !$this->issetParam( "token" ) ) {
            $this->view->render404();
        }

		$businessRepo = $this->load( "business-repository" );
        $embeddableFormElementTypeRepo = $this->load( "embeddable-form-element-type-repository" );
        $embeddableFormElementRepo = $this->load( "embeddable-form-element-repository" );
        $embeddableFormRepo = $this->load( "embeddable-form-repository" );
        $HTMLFormBuilder = $this->load( "html-form-builder" );

		$business = $businessRepo->get( [ "*" ], [ "id" => $this->params[ "id" ] ], "single" );
        $embeddableForm = $embeddableFormRepo->get( [ "*" ], [ "business_id" => $this->params[ "id" ], "token" => $this->params[ "token" ] ], "single" );

		if ( is_null( $business ) || is_null( $embeddableForm ) ) {
			$this->view->render404();
		}

        $embeddableForm->elements = $embeddableFormElementRepo->getAllByEmbeddableFormID( $embeddableForm->id );

        $HTMLFormBuilder->setAction( "https://www.jiujitsuscout.com/form/" . $embeddableForm->token . "/new-prospect" );
        $HTMLFormBuilder->setToken( $embeddableForm->token );
        $HTMLFormBuilder->setApplicationPrefix( "EmbeddableFormWidgetByJiuJitsuScout__" );
        $HTMLFormBuilder->setJavascriptResourceURL( "https://www.jiujitsuscout.com/public/static/js/embeddable-form.js" );
        $HTMLFormBuilder->setFormOffer( $embeddableForm->offer );

        if ( !empty( $embeddableForm->elements ) ) {
            foreach ( $embeddableForm->elements as $element ) {
                $element->type = $embeddableFormElementTypeRepo->getByID( $element->embeddable_form_element_type_id );
                $HTMLFormBuilder->addField(
                    $element->type->name,
                    $element->type->name,
                    $required = $element->required ? true : false,
                    $text = $element->text,
                    $value = null
                );
            }
        }

        $this->view->assign( "formHTML", htmlspecialchars_decode($HTMLFormBuilder->getFormHTML()) );

		$this->view->setTemplate( "forms.tpl" );
		$this->view->render( "App/Views/Home.php" );
	}

	public function iframe()
	{
		echo( "<iframe src=\"" . HOME . "forms/46/7b8857ed2af3c6bd9be7e46497e771be\" frameborder=\"0\" marginheight=\"0\" marginwidth=\"0\"></iframe>" );
	}
}
