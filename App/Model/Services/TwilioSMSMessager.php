<?php

namespace Model\Services;

use Contracts\SMSMessagerInterface;

class TwilioSMSMessager implements SMSMessagerInterface
{
    private $recipient_country_code;
    private $recipient_phone_number;
    private $sender_country_code;
    private $sender_phone_number;
    private $sms_body;

    public function send()
    {
        return $this;
    }

    public function setRecipientCountryCode( $country_code )
    {
        $this->recipient_country_code = $country_code;
    }

    public function setRecipientPhoneNumber( $number )
    {
        $this->recipient_phone_number = $number;
    }

    public function setSenderCountryCode( $country_code )
    {
        $this->sender_country_code = $country_code;
    }

    public function setSenderPhoneNumber( $number )
    {
        $this->sender_phone_number = $number;
    }

    public function setSMSBody( $body )
    {
        $this->sms_body = $body;
    }
}
