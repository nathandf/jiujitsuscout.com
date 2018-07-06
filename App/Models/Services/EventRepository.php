<?php

namespace Models\Services;

class EventRepository extends Service
{

    public function getAll()
    {
        $eventMapper = new \Models\Mappers\EventMapper( $this->container );
        $events = $eventMapper->mapAll();

        return $events;
    }

    public function getAllFromSequenceID( $sequence_id )
    {
        $eventMapper = new \Models\Mappers\EventMapper( $this->container );
        $events = $eventMapper->mapAllFromSequenceID( $sequence_id );

        return $events;
    }

    public function getAllFromBusinessID( $business_id )
    {
        $eventMapper = new \Models\Mappers\EventMapper( $this->container );
        $events = $eventMapper->mapAllFromBusinessID( $business_id );

        return $events;
    }

    public function getByID( $id )
    {
        $event = new \Models\Event();
        $eventMapper = new \Models\Mappers\EventMapper( $this->container );
        $eventMapper->mapFromID( $event, $id );

        return $event;
    }

}
