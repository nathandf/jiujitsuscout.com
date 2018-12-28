<?php

namespace Model\Mappers;

class EventMapper extends DataMapper
{

  public function mapAll()
  {
    
    $events = [];
    $sql = $this->DB->prepare( "SELECT * FROM event" );
    $sql->execute();
    while ( $resp = $sql->fetch( \PDO::FETCH_ASSOC ) ) {
      $this->populateEvent( $event, $resp );
      $events[] = $event;
    }
    return $events;
  }

  public function mapAllFromSequenceID( $sequence_id )
  {
    
    $events = [];
    $sql = $this->DB->prepare( "SELECT * FROM event WHERE sequence_id = :sequence_id" );
    $sql->bindParam( ":sequence_id", $sequence_id );
    $sql->execute();
    while ( $resp = $sql->fetch( \PDO::FETCH_ASSOC ) ) {
      $this->populateEvent( $event, $resp );
      $events[] = $event;
    }
    return $events;
  }

  public function mapAllFromBusinessID( $busines_id )
  {
    
    $events = [];
    $sql = $this->DB->prepare( "SELECT * FROM event WHERE business_id = :business_id" );
    $sql->bindParam( ":business_id", $business_id );
    $sql->execute();
    while ( $resp = $sql->fetch( \PDO::FETCH_ASSOC ) ) {
      $this->populateEvent( $event, $resp );
      $events[] = $event;
    }
    return $events;
  }

  public function mapFromID( \Model\Event $event, $id )
  {
    $sql = $this->DB->prepare( "SELECT * FROM event WHERE id = :id" );
    $sql->bindParam( ":id", $id );
    $sql->execute();
    $resp = $sql->fetch( \PDO::FETCH_ASSOC );
    $this->populateEvent( $event, $resp );
    return $event;
  }

  private function populateEvent( \Model\Event $event, $data )
  {
    $event->id            = $data[ "id" ];
    $event->business_id   = $data[ "business_id" ];
    $event->sequence_id   = $data[ "sequence_id" ];
    $event->event_type_id = $data[ "event_type_id" ];
    $event->time          = $data[ "time" ];
    $event->status       = $data[ "status" ];
  }

}
