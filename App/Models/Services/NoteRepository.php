<?php

namespace Models\Services;

class NoteRepository extends Service
{

    public function save( \Models\Note $note )
    {
        $noteMapper = new \Models\Mappers\NoteMapper( $this->container );
        $id = $noteMapper->create( $note );

        return $id;
    }

    public function getByID( $id )
    {
        $note = new \Models\Note;
        $noteMapper = new \Models\Mappers\NoteMapper( $this->container );
        $noteMapper->mapFromID( $note, $id );

        return $note;
    }

    public function getAllByProspectID( $prospect_id )
    {
        $noteMapper = new \Models\Mappers\NoteMapper( $this->container );
        $notes = $noteMapper->mapAllFromProspectID( $prospect_id );

        return $notes;
    }

    public function getAllByAppointmentID( $appointment_id )
    {
        $noteMapper = new \Models\Mappers\NoteMapper( $this->container );
        $notes = $noteMapper->mapAllFromAppointmentID( $appointment_id );

        return $notes;
    }

    public function getAllByMemberID( $member_id )
    {
        $noteMapper = new \Models\Mappers\NoteMapper( $this->container );
        $notes = $noteMapper->mapAllFromMemberID( $member_id );

        return $notes;
    }

    public function removeByID( $id )
    {
        $noteMapper = new \Models\Mappers\NoteMapper( $this->container );
        $noteMapper->delete( $id );
    }

    public function removeAllByAppointmentID( $id )
    {
        $noteMapper = new \Models\Mappers\NoteMapper( $this->container );
        $noteMapper->deleteAllByAppointmentID( $id );
    }

}
