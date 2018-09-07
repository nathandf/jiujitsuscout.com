<?php

namespace Model\Services;

class AppointmentHashRepository extends Service
{

    public function create( $appointment_id )
    {
        $appointmentHash = new \Model\AppointmentHash();
        $appointmentHashMapper = new \Model\Mappers\AppointmentHashMapper( $this->container );
        $appointmentHash->appointment_id = $appointment_id;
        $appointmentHash->hash = md5( $appointment_id . microtime() );
        $appointmentHashMapper->create( $appointmentHash );

        return $appointmentHash;
    }

    public function getByID( $id )
    {
        $appointmentHash = new \Model\AppointmentHash();
        $appointmentHashMapper = new \Model\Mappers\AppointmentHashMapper( $this->container );
        $appointmentHashMapper->mapFromID( $appointmentHash, $id );

        return $appointmentHash;
    }

    public function getByHash( $hash )
    {
        $appointmentHash = new \Model\AppointmentHash();
        $appointmentHashMapper = new \Model\Mappers\AppointmentHashMapper( $this->container );
        $appointmentHashMapper->mapFromHash( $appointmentHash, $hash );

        return $appointmentHash;
    }


    public function removeByID( $id )
    {
        $appointmentHashMapper = new \Model\Mappers\AppointmentHashMapper( $this->container );
        $appointmentHashMapper->deleteByID( $id );
    }

    public function removeByHash( $hash )
    {
        $appointmentHashMapper = new \Model\Mappers\AppointmentHashMapper( $this->container );
        $appointmentHashMapper->deleteByHash( $hash );
    }

}
