<?php

namespace Model\Services;

class EventTypeRepository extends Service
{

  public function getAll()
  {
    $eventTypeMapper = new \Model\Mappers\EventTypeMapper( $this->container );
    $eventTypes = $eventTypeMapper->mapAll();
    return $eventTypes;
  }

  public function getByID( $id )
  {
    $eventType = new \Model\EventType();
    $eventTypeMapper = new \Model\Mappers\EventTypeMapper( $this->container );
    $eventTypeMapper->mapFromID( $eventType, $id );

    return $eventType;
  }

}
