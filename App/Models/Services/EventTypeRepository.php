<?php

namespace Models\Services;

class EventTypeRepository extends Service
{

  public function getAll()
  {
    $eventTypeMapper = new \Models\Mappers\EventTypeMapper( $this->container );
    $eventTypes = $eventTypeMapper->mapAll();
    return $eventTypes;
  }

  public function getByID( $id )
  {
    $eventType = new \Models\EventType();
    $eventTypeMapper = new \Models\Mappers\EventTypeMapper( $this->container );
    $eventTypeMapper->mapFromID( $eventType, $id );

    return $eventType;
  }

}
