<?php

namespace Model\Services;

class NoteRegistrar
{

    public $factory;
    public $noteRepo;

    public function __construct( NoteRepository $repo, EntityFactory $factory )
    {
        $this->noteRepo = $repo;
        $this->factory = $factory;
    }

    public function save( $body, $business_id, $user_id = null, $prospect_id = null, $member_id = null, $appointment_id = null )
    {
        $note = $this->factory->build( "Note" );
        $note->business_id            = $business_id;
        $note->user_id                = $user_id;
        $note->prospect_id            = $prospect_id;
        $note->member_id              = $member_id;
        $note->appointment_id         = $appointment_id;
        $note->body                   = $body;
        $note->time                   = time();

        // Save note and get new id
        $note_id = $this->noteRepo->save( $note );

        return $note_id;
    }

}
