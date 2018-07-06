<?php

namespace Models\Mappers;

class EventTextMessageMapper extends DataMapper
{

  public function mapAll()
  {
    $entityFactory = $this->container->getService( "entity-factory" );
    $eventTextMessages = [];
    $sql = $this->DB->prepare( "SELECT * FROM event_text_message" );
    $sql->execute();
    while ( $resp = $sql->fetch( \PDO::FETCH_ASSOC ) ) {
      $eventTextMessage = $entityFactory->build( "EventTextMessage" );
      $this->populateEventTextMessage( $eventTextMessage, $resp );
      $eventTextMessages[] = $eventTextMessage;
    }

    return $eventTextMessages;
  }

  public function mapFromID( \Models\EventTextMessage $eventTextMessage, $id )
  {
    $sql = $this->DB->prepare( "SELECT * FROM event_text_message WHERE id = :id" );
    $sql->bindParam( ":id", $id );
    $sql->execute();
    $resp = $sql->fetch( \PDO::FETCH_ASSOC );
    $this->populateEventTextMessage( $eventTextMessage, $resp );
    return $eventTextMessage;
  }

  public function mapFromEventID( \Models\EventTextMessage $eventTextMessage, $id )
  {
    $sql = $this->DB->prepare( "SELECT * FROM event_text_message WHERE event_id = :id" );
    $sql->bindParam( ":id", $id );
    $sql->execute();
    $resp = $sql->fetch( \PDO::FETCH_ASSOC );
    $this->populateEventTextMessage( $eventTextMessage, $resp );
    return $eventTextMessage;
  }

  private function populateEventTextMessage( \Models\EventTextMessage $eventTextMessage, $data )
  {
    $eventTextMessage->id                = $data[ "id" ];
    $eventTextMessage->event_id          = $data[ "event_id" ];
    $eventTextMessage->text_message_id   = $data[ "text_message_id" ];
  }

}
