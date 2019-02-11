<?php

namespace Model\Services;

class EventRepository extends Repository
{
    public function getAll()
    {
        $mapper = $this->getMapper();
        $events = $mapper->mapAll();

        return $events;
    }

    public function getAllBySequenceID( $sequence_id )
    {
        $mapper = $this->getMapper();
        $events = $mapper->mapAllFromSequenceID( $sequence_id );

        return $events;
    }

    public function getAllFromBusinessID( $business_id )
    {
        $mapper = $this->getMapper();
        $events = $mapper->mapAllFromBusinessID( $business_id );

        return $events;
    }

    public function getByID( $id )
    {
        $mapper = $this->getMapper();
        $event = $mapper->build( $this->entityName );
        $mapper->mapFromID( $event, $id );

        return $event;
    }
}
