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
        $input = $this->load( "input" );
        $smsMessager = $this->load( "sms-messager" );

        if ( $input->exists() && $input->issetField( "body" ) ) {
            $smsMessager->setRecipientCountryCode( 1 )
                ->setRecipientNationalNumber( "8122763172" )
                ->setSenderCountryCode( 1 )
                ->setSenderNationalNumber( "2812451567" )
                ->setSMSBody( trim( $input->get( "body" ) ) )
                ->send();
            $this->view->redirect( "test/twilio" );
        }

        $this->view->setTemplate( "test/sms-message.tpl" );
        $this->view->render( "App/Views/Home.php" );
    }

    public function twilioPurchaseNumber()
    {
        $businessRepo = $this->load( "business-repository" );
        $twilioServiceDispatcher = $this->load( "twilio-service-dispatcher" );

        $business = $businessRepo->get( [ "*" ], [ "id" => 1 ], "single" );

        $number = $twilioServiceDispatcher->purchaseNumber(
            "US",
            $business->getLatLonArray()
        );
    }

    public function twilioCall()
    {
        $twilioServiceDispatcher = $this->load( "twilio-service-dispatcher" );
        $twilioServiceDispatcher->call( "+18122763172", "+12812451567"  );
    }
}
