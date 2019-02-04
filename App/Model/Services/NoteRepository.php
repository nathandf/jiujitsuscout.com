<?php

namespace Model\Services;

class NoteRepository extends Repository
{
    public function save( \Model\Note $note )
    {
        $mapper = $this->getMapper();
        $id = $mapper->create( $note );

        return $id;
    }

    public function getByID( $id )
    {
        $mapper = $this->getMapper();
        $note = $mapper->build( $this->entityName );
        $mapper->mapFromID( $note, $id );

        return $note;
    }

    public function getAllByProspectID( $prospect_id )
    {
        $mapper = $this->getMapper();
        $notes = $mapper->mapAllFromProspectID( $prospect_id );

        return $notes;
    }

    public function getAllByAppointmentID( $appointment_id )
    {
        $mapper = $this->getMapper();
        $notes = $mapper->mapAllFromAppointmentID( $appointment_id );

        return $notes;
    }

    public function getAllByMemberID( $member_id )
    {
        $mapper = $this->getMapper();
        $notes = $mapper->mapAllFromMemberID( $member_id );

        return $notes;
    }

    public function removeByID( $id )
    {
        $mapper = $this->getMapper();
        $mapper->delete( [ "id" ], [ $id ] );
    }

    public function removeAllByAppointmentID( $id )
    {
        $mapper = $this->getMapper();
        $mapper->deleteAllByAppointmentID( $id );
    }
}
