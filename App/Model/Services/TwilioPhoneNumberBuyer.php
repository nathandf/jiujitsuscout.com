<?php

namespace Model\Services;

use \Model\Services\TwilioAPIInitializer;
use Twilio\Twiml;

class TwilioPhoneNumberBuyer
{
    private $api;
    private $client;
    public $twilio_phone_number_instance;

    public function __construct(
        TwilioAPIInitializer $twilioAPIInitializer
    ){
        $this->api = $twilioAPIInitializer;
        $this->client = $this->api->init();
    }

    public function buy( $twilio_phone_number_instance )
    {
        die( "delete die to purchase" );
        // Purchase the first number on the list.
        $number = $this->client->incomingPhoneNumbers
            ->create(
                [
                    "phoneNumber" => $twilio_phone_number_instance->phoneNumber,
                ]
            );

        $number = $this->configure( $number );

        return $number;
    }

    public function configure( $phone_number_instance )
    {
        $number = $this->client->incomingPhoneNumbers( $phone_number_instance->sid )
            ->update(
                [
                    "smsMethod" => "POST",
                    "smsUrl" => "https://jiujitsuscout.com/webhooks/twilio/{$phone_number_instance->sid}/incoming/sms",
                    "voiceMethod" => "POST",
                    "voiceUrl" => "https://jiujitsuscout.com/webhooks/twilio/{$phone_number_instance->sid}/incoming/voice"
                ]
            );

        return $number;
    }

    public function fetchByPhoneNumber( $twilio_phone_number )
    {
        // Purchase the first number on the list.
        $number = $this->client->incomingPhoneNumbers
            ->create(
                [
                    "phoneNumber" => $twilio_phone_number,
                ]
            );

        return $number;
    }

    // arg twilio_phone_number should be E164 Formatted
    public function updateByPhoneNumber( $twilio_phone_number )
    {
        $number = $this->fetchByPhoneNumber( $twilio_phone_number );
        $number = $this->configure( $number );

        return $number;
    }

}
