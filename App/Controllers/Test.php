<?php

namespace Controllers;

use \Core\Controller;

class Test extends Controller
{
    public function braintree()
	{
        $input = $this->load( "input" );
        $inputValidator = $this->load( "input-validator" );
		$productRepo = $this->load( "product-repository" );

        $products = $productRepo->getAll();

        $this->view->assign( "products", $products );

		$this->view->assign( "csrf_token", $this->session->generateCSRFToken() );
	    $this->view->setErrorMessages( $inputValidator->getErrors() );

		$this->view->setTemplate( "braintree-test.tpl" );
		$this->view->render( "App/Views/Home.php" );
	}

    public function unsetAll()
    {
        unset( $_SESSION[ "respondent-token" ] );
    }

    public function twilio()
    {
        $smsMessager = $this->load( "sms-messager" );
        $smsMessager->setRecipientCountryCode( 1 )
            ->setRecipientNationalNumber( "8122763172" )
            ->setSenderCountryCode( 1 )
            ->setSenderNationalNumber( "2812451567" )
            ->setSMSBody( "This is a test" )
            ->send();
    }
}
