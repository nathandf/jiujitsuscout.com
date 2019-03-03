<?php

namespace Controllers\Webhooks\Twilio;

use \Core\Controller;

class Incoming extends Controller
{
    public $business_phone = null;

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

        $business = $businessRepo->get( [ "*" ], [ "id" => $this->twilioPhoneNumber->business_id ], "single" );
        if ( !is_null( $business ) ) {
            $this->business_phone = $phoneRepo->get( [ "*" ], [ "id" => $business->phone_id ], "single" );
        }
    }

    public function smsAction()
    {
        // TODO get sender data
    }

    public function voiceAction()
    {
        // Forward the call the business's phone number
        if ( !is_null( $this->business_phone ) ) {
            $this->twilioServiceDispatcher->forwardCall(
                $this->business_phone->getE164FormattedPhoneNumber()
            );
        }
    }
}
