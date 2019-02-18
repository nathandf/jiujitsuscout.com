<?php

namespace Contracts;

interface SMSMessagerInterface
{
    public function send();
    public function setRecipientCountryCode( $country_code );
    public function setRecipientNationalNumber( $number );
    public function setSenderCountryCode( $country_code );
    public function setSenderNationalNumber( $number );
    public function setSMSBody( $body );
}
