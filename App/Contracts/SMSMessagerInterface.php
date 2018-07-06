<?php

namespace Contracts;

interface SMSMessagerInterface
{
  public function send();

  public function setRecipientCountryCode( $country_code );

  public function setRecipientPhoneNumber( $number );

  public function setSenderCountryCode( $country_code );

  public function setSenderPhoneNumber( $number );

  public function setSMSBody( $body );
}
