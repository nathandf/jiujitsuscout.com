<?php

namespace Controllers\Webhooks\Twilio;

use \Core\Controller;

class Incoming extends Controller
{
    public function before()
    {
        $this->requireParam( "sid" );
        $businessRepo = $this->load( "business-repository" );
        $phoneRepo = $this->load( "phone-repository" );
        $this->twilioServiceDispatcher = $this->load( "twilio-service-dispatcher" );
        $twilioPhoneNumberRepo = $this->load( "twilio-phone-number-repository" );

        $this->twilioPhoneNumber = $twilioPhoneNumberRepo->get( [ "*" ], [ "sid" => $this->params[ "sid" ] ], "single" );

        // If no twilio phone number exists
        if ( is_null( $this->twilioPhoneNumber ) ) {
            return;
        }

        $this->business = $businessRepo->get( [ "*" ], [ "id" => $this->twilioPhoneNumber->business_id ], "single" );
        $this->business->phone = $phoneRepo->get( [ "*" ], [ "id" => $this->business->phone_id ], "single" );
    }

    public function smsAction()
    {
        // TODO get sender data
    }

    public function callAction()
    {
        // Forward the call the business's phone number
        $this->twilioServiceDispatcher->forwardCall(
            $this->business->phone->getE164FormattedPhoneNumber()
        );
    }
}
