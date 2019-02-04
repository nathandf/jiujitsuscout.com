<?php

namespace Model\Services;

class EventTypeRepository extends Repository
{
    public function getAll()
    {
        $mapper = $this->getMapper();
        $eventTypes = $mapper->mapAll();

        return $eventTypes;
    }

    public function getByID( $id )
    {
        $mapper = $this->getMapper();
        $eventType = $mapper->build( $this->entityName );
        $mapper->mapFromID( $eventType, $id );

        return $eventType;
    }
}
