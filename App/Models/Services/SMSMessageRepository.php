<?php

namespace Models\Services;

class SMSMessageRepository extends Service
{

  public function getAllByMDNPair( $mdn_1, $mdn_2 )
  {
    $mdn_pair_1 = $mdn_1 . ":" . $mdn_2;
    $mdn_pair_2 = $mdn_2 . ":" . $mdn_1;
    $smsMessageMapper = new \Models\Mappers\SMSMessageMapper( $this->container );
    $smsMessages = $smsMessageMapper->mapAllFromMDNPair( $mdn_pair_1, $mdn_pair_2 );
    return $smsMessages;
  }

  public function save( \Models\SMSMessage $smsMessage, array $sms_data )
  {
    $smsMessage->setSenderCountryCode( $sms_data[ "sender_country_code" ] );
    $smsMessage->setSenderPhoneNumber( $sms_data[ "sender_phone_number" ] );
    $smsMessage->setRecipientCountryCode( $sms_data[ "recipient_country_code" ] );
    $smsMessage->setRecipientPhoneNumber( $sms_data[ "recipient_phone_number" ] );
    $smsMessage->setMDNPair( $smsMessage->getSenderPhoneNumber(), $smsMessage->getRecipientPhoneNumber() );
    $smsMessage->setMessageBody( $sms_data[ "sms_body" ] );
    $smsMessage->setUTCTimeSent( $sms_data[ "utc_time_sent" ] );
    $smsMessageMapper = new \Models\Mappers\SMSMessageMapper( $this->container );
    $smsMessageMapper->saveSMS( $smsMessage );
  }

}
