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
        unset( $_SESSION[ "landing-page-sign-up" ] );
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
        $countryRepo = $this->load( "country-repository" );
        $addressRepo = $this->load( "address-repository" );
        $twilioPhoneNumberRepo = $this->load( "twilio-phone-number-repository" );
        $twilioServiceDispatcher = $this->load( "twilio-service-dispatcher" );
        $twilioPhoneNumberBuyer = $this->load( "twilio-phone-number-buyer" );

        $business = $businessRepo->get( [ "*" ], [ "id" => 64 ], "single" );
        $business->address = $addressRepo->get( [ "*" ], [ "id" => $business->address_id ], "single" );
        $business->country = $countryRepo->get( [ "*" ], [ "id" => $business->address->country_id ], "single" );

        $numbers = $twilioServiceDispatcher->findAvailableNumbersNearLatLon(
            $business->country->iso,
            $business->getLatLonArray()
        );

        // Purchase a local number if one exists
        if ( !empty( $numbers ) ) {
            $number = $twilioPhoneNumberBuyer->buy( $numbers[ 0 ] );
            if ( $number ) {
                // Create a twilio phone number entity if a number was purchased
                $twilioPhoneNumberRepo->create([
                    "business_id" => $business->id,
                    "sid" => $number->sid,
                    "phone_number" => $number->phoneNumber,
                    "friendly_name" => $number->friendlyName
                ]);
            }
        }
    }

    public function twilioCall()
    {
        $twilioServiceDispatcher = $this->load( "twilio-service-dispatcher" );
        $twilioServiceDispatcher->call( "+18122763172", "+12812451567"  );
    }

    public function twilioFetchPhoneNumber()
    {
        $twilioPhoneNumberBuyer = $this->load( "twilio-phone-number-buyer" );
        $number = $twilioPhoneNumberBuyer->updateByPhoneNumber( "+13462203101" );
    }
}
