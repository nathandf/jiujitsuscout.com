<?php

namespace Model\Mappers;

class EventEmailMapper extends DataMapper
{

  public function mapAll()
  {
    $entityFactory = $this->container->getService( "entity-factory" );
    $eventEmails = [];
    $sql = $this->DB->prepare( "SELECT * FROM event_email" );
    $sql->execute();
    while ( $resp = $sql->fetch( \PDO::FETCH_ASSOC ) ) {
      $eventEmail = $entityFactory->build( "EventEmail" );
      $this->populateEventEmail( $eventEmail, $resp );
      $eventEmails[] = $eventEmail;
    }

    return $eventEmails;
  }

  public function mapFromID( \Model\EventEmail $eventEmail, $id )
  {
    $sql = $this->DB->prepare( "SELECT * FROM event_email WHERE id = :id" );
    $sql->bindParam( ":id", $id );
    $sql->execute();
    $resp = $sql->fetch( \PDO::FETCH_ASSOC );
    $this->populateEventEmail( $eventEmail, $resp );
    return $eventEmail;
  }

  public function mapFromEventID( \Model\EventEmail $eventEmail, $id )
  {
    $sql = $this->DB->prepare( "SELECT * FROM event_email WHERE event_id = :id" );
    $sql->bindParam( ":id", $id );
    $sql->execute();
    $resp = $sql->fetch( \PDO::FETCH_ASSOC );
    $this->populateEventEmail( $eventEmail, $resp );
    return $eventEmail;
  }

  private function populateEventEmail( \Model\EventEmail $eventEmail, $data )
  {
    $eventEmail->id                = $data[ "id" ];
    $eventEmail->event_id          = $data[ "event_id" ];
    $eventEmail->email_id          = $data[ "email_id" ];
  }

}
