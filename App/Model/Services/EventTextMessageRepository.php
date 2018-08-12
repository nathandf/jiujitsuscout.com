<?php

namespace Model\Services;

class EventTextMessageRepository extends Service
{

  public function getAll()
  {
    $eventTextMessageMapper = new \Model\Mappers\EventTextMessageMapper( $this->container );
    $eventTextMessages = $eventTextMessageMapper->mapAll();
    return $eventTextMessages;
  }

  public function getByID( $id )
  {
    $eventTextMessage = new \Model\EventTextMessage();
    $eventTextMessageMapper = new \Model\Mappers\EventTextMessageMapper( $this->container );
    $eventTextMessageMapper->mapFromID( $eventTextMessage, $id );

    return $eventTextMessage;
  }

  public function getByEventID( $event_id )
  {
    $eventTextMessage = new \Model\EventTextMessage();
    $eventTextMessageMapper = new \Model\Mappers\EventTextMessageMapper( $this->container );
    $eventTextMessageMapper->mapFromEventID( $eventTextMessage, $event_id );

    return $eventTextMessage;
  }

}
