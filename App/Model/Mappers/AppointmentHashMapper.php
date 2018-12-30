<?php

namespace Model\Mappers;

use Model\AppointmentHash;

class AppointmentHashMapper extends DataMapper
{
    public function create( AppointmentHash $appointmentHash )
    {
        $id = $this->insert(
                    "appointment_hash",
                    [ "appointment_id", "hash" ],
                    [ $appointmentHash->appointment_id, $appointmentHash->hash ]
                  );
        $appointmentHash->id = $id;

        return $appointmentHash;
    }

    public function mapFromID( AppointmentHash $appointmentHash, $id )
    {
        $sql = $this->DB->prepare( "SELECT * FROM appointment_hash WHERE id = :id" );
        $sql->bindParam( ":id", $id );
        $sql->execute();
        $resp = $sql->fetch( \PDO::FETCH_ASSOC );
        $this->populate( $appointmentHash, $resp );

        return $appointmentHash;
    }

    public function mapFromHash( AppointmentHash $appointmentHash, $hash )
    {
        $sql = $this->DB->prepare( "SELECT * FROM appointment_hash WHERE hash = :hash" );
        $sql->bindParam( ":hash", $hash );
        $sql->execute();
        $resp = $sql->fetch( \PDO::FETCH_ASSOC );
        $this->populate( $appointmentHash, $resp );

        return $appointmentHash;
    }

    public function deleteByID( $id )
    {
        $sql = $this->DB->prepare( "DELETE FROM appointment_hash WHERE id = :id" );
        $sql->bindParam( ":id", $id );
        $sql->execute();
    }

    public function deleteByHash( $hash )
    {
        $sql = $this->DB->prepare( "DELETE FROM appointment_hash WHERE hash = :hash" );
        $sql->bindParam( ":hash", $hash );
        $sql->execute();
    }
}
