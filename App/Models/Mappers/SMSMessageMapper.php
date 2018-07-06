<?php

namespace Models\Mappers;

class SMSMessageMapper extends DataMapper
{

  public function mapAllFromMDNPair( $mdn_pair_1, $mdn_pair_2 )
  {
    $entityFactory = $this->container->getService( "entity-factory" );
    $smsMessages = [];
    $sql = $this->DB->prepare( "SELECT * FROM sms_message WHERE mdn_pair = :mdn_pair_1 OR mdn_pair = :mdn_pair_2 ORDER BY utc_time_sent" );
    $sql->bindParam( ":mdn_pair_1", $mdn_pair_1 );
    $sql->bindParam( ":mdn_pair_2", $mdn_pair_2 );
    $sql->execute();
    while ( $resp = $sql->fetch( \PDO::FETCH_ASSOC ) ) {
      $sms = $entityFactory->build( "SMSMessage" );
      $sms->id = $resp[ "id" ];
      $sms->sender_country_code = $resp[ "sender_country_code" ];
      $sms->sender_phone_number = $resp[ "sender_phone_number" ];
      $sms->sender_full_mdn = $resp[ "sender_full_mdn" ];
      $sms->recipient_country_code = $resp[ "recipient_country_code" ];
      $sms->recipient_phone_number = $resp[ "recipient_phone_number" ];
      $sms->recipient_full_mdn = $resp[ "recipient_full_mdn" ];
      $sms->mdn_pair = $resp[ "mdn_pair" ];
      $sms->sms_body = $resp[ "sms_body" ];
      $sms->utc_time_sent = $resp[ "utc_time_sent" ];
      $smsMessages[] = $sms;
    }

    return $smsMessages;
  }

  public function saveSMS( \Models\SMSMessage $sms )
  {
    $this->insert( "sms_message",
                  [
                    "sender_country_code", "sender_phone_number", "sender_full_mdn",
                    "recipient_country_code", "recipient_phone_number",
                    "recipient_full_mdn", "mdn_pair", "sms_body", "utc_time_sent"
                    ],
                  [
                    $sms->sender_country_code, $sms->sender_phone_number, $sms->getSenderFullMDN(),
                    $sms->recipient_country_code, $sms->recipient_phone_number, $sms->getRecipientFullMDN(),
                    $sms->getMDNPair(), $sms->message_body, $sms->utc_time_sent
                    ]
                );
  }

}
