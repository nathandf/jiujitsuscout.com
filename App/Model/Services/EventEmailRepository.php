<?php

namespace Model\Services;

class EventEmailRepository extends Service
{

    public function getAll()
    {
        $eventEmailMapper = new \Model\Mappers\EventEmailMapper( $this->container );
        $eventEmails = $eventEmailMapper->mapAll();

        return $eventEmails;
    }

    public function getByID( $id )
    {
        $eventEmail = new \Model\EventEmail();
        $eventEmailMapper = new \Model\Mappers\EventEmailMapper( $this->container );
        $eventEmailMapper->mapFromID( $eventEmail, $id );

        return $eventEmail;
    }

    public function getByEventID( $event_id )
    {
        $eventEmail = new \Model\EventEmail();
        $eventEmailMapper = new \Model\Mappers\EventEmailMapper( $this->container );
        $eventEmailMapper->mapFromEventID( $eventEmail, $event_id );

        return $eventEmail;
    }

}
