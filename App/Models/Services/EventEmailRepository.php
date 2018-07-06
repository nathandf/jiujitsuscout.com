<?php

namespace Models\Services;

class EventEmailRepository extends Service
{

    public function getAll()
    {
        $eventEmailMapper = new \Models\Mappers\EventEmailMapper( $this->container );
        $eventEmails = $eventEmailMapper->mapAll();

        return $eventEmails;
    }

    public function getByID( $id )
    {
        $eventEmail = new \Models\EventEmail();
        $eventEmailMapper = new \Models\Mappers\EventEmailMapper( $this->container );
        $eventEmailMapper->mapFromID( $eventEmail, $id );

        return $eventEmail;
    }

    public function getByEventID( $event_id )
    {
        $eventEmail = new \Models\EventEmail();
        $eventEmailMapper = new \Models\Mappers\EventEmailMapper( $this->container );
        $eventEmailMapper->mapFromEventID( $eventEmail, $event_id );

        return $eventEmail;
    }

}
