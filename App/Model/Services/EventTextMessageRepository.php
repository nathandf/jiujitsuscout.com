<?php

namespace Model\Services;

class EventTextMessageRepository extends Repository
{
    public function getAll()
    {
        $mapper = $this->getMapper();
        $eventTextMessages = $mapper->mapAll();

        return $eventTextMessages;
    }

    public function getByID( $id )
    {
        $mapper = $this->getMapper();
        $eventTextMessage = $mapper->build( $this->entityName );
        $mapper->mapFromID( $eventTextMessage, $id );

        return $eventTextMessage;
    }

    public function getByEventID( $event_id )
    {
        $mapper = $this->getMapper();
        $eventTextMessage = $mapper->build( $this->entityName );
        $mapper->mapFromEventID( $eventTextMessage, $event_id );

        return $eventTextMessage;
    }
}
