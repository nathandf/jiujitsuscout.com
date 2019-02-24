<?php

namespace Controllers\Webhooks\Twilio;

use \Core\Controller;

class Incoming extends Controller
{
    public function before()
    {
        $this->requireParam( "id" );
        $businessRepo = $this->load( "business-repository" );
        $phoneRepo = $this->load( "phone-repository" );
        $this->twilioServiceDispatcher = $this->load( "twilio-service-dispatcher" );

        $this->business = $businessRepo->get( [ "*" ], [ "id" => $this->params[ "id" ] ], "single" );
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
