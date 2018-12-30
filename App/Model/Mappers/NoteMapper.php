<?php

namespace Model\Mappers;

use Model\Note;

class NoteMapper extends DataMapper
{
    public function create( Note $note )
    {
        $id = $this->insert(
            "note",
            [ "business_id", "user_id", "prospect_id", "member_id", "appointment_id", "body", "time" ],
            [ $note->business_id, $note->user_id, $note->prospect_id, $note->member_id, $note->appointment_id, $note->body, $note->time ]
        );

        return $id;
    }

    public function mapFromID( Note $note, $id )
    {
        $sql = $this->DB->prepare( "SELECT * FROM note WHERE id = :id" );
        $sql->bindParam( ":id", $id );
        $sql->execute();
        $resp = $sql->fetch( \PDO::FETCH_ASSOC );
        $this->populate( $note, $resp );

        return $note;
    }

    public function mapAllFromProspectID( $prospect_id )
    {
        $notes = [];
        $sql = $this->DB->prepare( 'SELECT * FROM note WHERE prospect_id = :prospect_id ORDER BY time DESC' );
        $sql->bindParam( ":prospect_id", $prospect_id );
        $sql->execute();

        while ( $resp = $sql->fetch( \PDO::FETCH_ASSOC ) ) {
            $note = $this->entityFactory->build( "Note" );
            $this->populate( $note, $resp );
            $notes[] = $note;
        }

        return $notes;
    }

    public function mapAllFromMemberID( $member_id )
    {
        $notes = [];
        $sql = $this->DB->prepare( 'SELECT * FROM note WHERE member_id = :member_id ORDER BY time DESC' );
        $sql->bindParam( ":member_id", $member_id );
        $sql->execute();

        while ( $resp = $sql->fetch( \PDO::FETCH_ASSOC ) ) {
            $note = $this->entityFactory->build( "Note" );
            $this->populate( $note, $resp );
            $notes[] = $note;
        }

        return $notes;
    }

    public function mapAllFromAppointmentID( $appointment_id )
    {
        $notes = [];
        $sql = $this->DB->prepare( 'SELECT * FROM note WHERE appointment_id = :appointment_id ORDER BY time DESC' );
        $sql->bindParam( ":appointment_id", $appointment_id );
        $sql->execute();

        while ( $resp = $sql->fetch( \PDO::FETCH_ASSOC ) ) {
            $note = $this->entityFactory->build( "Note" );
            $this->populate( $note, $resp );
            $notes[] = $note;
        }

        return $notes;
    }

    public function deleteAllByAppointmentID( $appointment_id )
    {
        if ( !is_null( $appointment_id ) ) {
            $sql = $this->DB->prepare( "DELETE FROM note WHERE appointment_id = :appointment_id" );
            $sql->bindParam( ":appointment_id", $appointment_id );
            $sql->execute();
        }
    }
}
