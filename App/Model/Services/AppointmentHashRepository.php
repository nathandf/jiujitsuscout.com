<?php

namespace Model\Services;

class AppointmentHashRepository extends Repository
{

    public function create( $appointment_id )
    {
        $mapper = $this->getMapper();
        $appointmentHash = $mapper->build( $this->entityName );
        $appointmentHash->appointment_id = $appointment_id;
        $appointmentHash->hash = md5( $appointment_id . microtime() );
        $mapper->create( $appointmentHash );

        return $appointmentHash;
    }

    public function getByID( $id )
    {
        $mapper = $this->getMapper();
        $appointmentHash = $mapper->build( $this->entityName );
        $mapper->mapFromID( $appointmentHash, $id );

        return $appointmentHash;
    }

    public function getByHash( $hash )
    {
        $mapper = $this->getMapper();
        $appointmentHash = $mapper->build( $this->entityName );
        $mapper->mapFromHash( $appointmentHash, $hash );

        return $appointmentHash;
    }


    public function removeByID( $id )
    {
        $mapper = $this->getMapper();
        $mapper->deleteByID( $id );
    }

    public function removeByHash( $hash )
    {
        $mapper = $this->getMapper();
        $mapper->deleteByHash( $hash );
    }

}
