<?php

namespace Model\Services;

class EventRepository extends Service
{
    public function getAll()
    {
        $eventMapper = new \Model\Mappers\EventMapper( $this->container );
        $events = $eventMapper->mapAll();

        return $events;
    }

    public function getAllBySequenceID( $sequence_id )
    {
        $eventMapper = new \Model\Mappers\EventMapper( $this->container );
        $events = $eventMapper->mapAllFromSequenceID( $sequence_id );

        return $events;
    }

    public function getAllFromBusinessID( $business_id )
    {
        $eventMapper = new \Model\Mappers\EventMapper( $this->container );
        $events = $eventMapper->mapAllFromBusinessID( $business_id );

        return $events;
    }

    public function getByID( $id )
    {
        $event = new \Model\Event();
        $eventMapper = new \Model\Mappers\EventMapper( $this->container );
        $eventMapper->mapFromID( $event, $id );

        return $event;
    }
}
