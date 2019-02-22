<?php

namespace Model\Services;

use Contracts\SMSMessagerInterface;
use \Model\Services\TwilioAPIInitializer;

class TwilioSMSMessager implements SMSMessagerInterface
{
    private $api;
    private $client;
    private $recipient_country_code;
    private $recipient_national_number;
    private $sender_country_code;
    private $sender_national_number;
    private $sms_body;

    public function __construct(
        TwilioAPIInitializer $twilioAPIInitializer
    ){
        $this->api = $twilioAPIInitializer;
        $this->client = $this->api->init();
    }

    public function send()
    {
        $message = $this->client->messages->create(
            $this->getRecipientFullPhoneNumber(),
            [
                "from" => $this->getSenderFullPhoneNumber(),
                "body" => $this->getSMSBody(),
                "statusCallback" => $this->api->getStatusCallback()
            ]
        );

        return $this;
    }

    public function setRecipientCountryCode( $country_code )
    {
        $this->recipient_country_code = $country_code;
        return $this;
    }

    public function getRecipientCountryCode()
    {
        if ( isset( $this->recipient_country_code ) === false ) {
            throw new \Exception( "Recipient country code is not set" );
        }

        return $this->recipient_country_code;
    }

    public function setRecipientNationalNumber( $number )
    {
        $this->recipient_national_number = $number;
        return $this;
    }

    public function getRecipientNationalNumber()
    {
        if ( isset( $this->recipient_national_number ) === false ) {
            throw new \Exception( "Recipient national number is not set" );
        }

        return $this->recipient_national_number;
    }

    public function setSenderCountryCode( $country_code )
    {
        $this->sender_country_code = $country_code;
        return $this;
    }

    public function getSenderCountryCode()
    {
        if ( isset( $this->sender_country_code ) === false ) {
            throw new \Exception( "Sender country code is not set" );
        }

        return $this->sender_country_code;
    }

    public function setSenderNationalNumber( $number )
    {
        $this->sender_national_number = $number;
        return $this;
    }

    public function getSenderNationalNumber()
    {
        if ( isset( $this->sender_national_number ) === false ) {
            throw new \Exception( "Sender national number is not set" );
        }

        return $this->sender_national_number;
    }

    public function setSMSBody( $body )
    {
        $this->sms_body = $body;
        return $this;
    }

    public function getSMSBody()
    {
        if ( isset( $this->sms_body ) === false ) {
            throw new \Exception( "SMS Body is not set" );
        }

        return $this->sms_body;
    }

    public function getRecipientFullPhoneNumber()
    {
        return "+" . $this->getRecipientCountryCode() . $this->getRecipientNationalNumber();
    }

    public function getSenderFullPhoneNumber()
    {
        return "+" . $this->getSenderCountryCode() . $this->getSenderNationalNumber();
    }
}
