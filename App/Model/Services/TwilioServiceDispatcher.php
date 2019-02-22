<?php

namespace Model\Services;

use \Model\Services\TwilioAPIInitializer;
use Twilio\Twiml;

class TwilioServiceDispatcher
{
    private $api;
    private $client;

    public function __construct(
        TwilioAPIInitializer $twilioAPIInitializer
    ){
        $this->api = $twilioAPIInitializer;
        $this->client = $this->api->init();
    }

    // $iso -> ISO6631-1 alpha-2 format
    public function findAvailableNumbersNearLatLon( $iso, array $latLonArray )
    {
        $numbers = [];
        if ( !empty( $latLonArray ) ) {
            $numbers = $this->client->availablePhoneNumbers( $iso )->local->read(
                [ "nearLatLong" => implode( ",", $latLonArray ) ]
            );
        }

        return $numbers;
    }

    public function purchaseNumber( $iso, array $latLonArray )
    {
        $numbers = $this->findAvailableNumbersNearLatLon(
            $iso,
            $latLonArray
        );

        $number = null;
        if ( !empty( $numbers ) ) {
            // Purchase the first number on the list.
            $number = $this->client->incomingPhoneNumbers
                ->create(
                    [
                        "phoneNumber" => $numbers[0]->phoneNumber
                    ]
                );
        }

        return $number;
    }

    public function forwardCall( $phone_number )
    {
        $twiml = new Twiml();
        $wiml->dial( $this->formatPhoneNumberE164( $phone_number ) );
    }

    private function formatPhoneNumberE164( $phone_number )
    {
        return $phone_number;
    }
}
