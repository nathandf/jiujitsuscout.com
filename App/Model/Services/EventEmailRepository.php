<?php

namespace Model\Services;

class EventEmailRepository extends Repository
{
    public function getAll()
    {
        $mapper = $this->getMapper();
        $eventEmails = $mapper->mapAll();

        return $eventEmails;
    }

    public function getByID( $id )
    {
        $mapper = $this->getMapper();
        $eventEmail = $mapper->build( $this->entityName );
        $mapper->mapFromID( $eventEmail, $id );

        return $eventEmail;
    }

    public function getByEventID( $event_id )
    {
        $mapper = $this->getMapper();
        $eventEmail = $mapper->build( $this->entityName );
        $mapper->mapFromEventID( $eventEmail, $event_id );

        return $eventEmail;
    }
}
