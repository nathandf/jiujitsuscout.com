<?php

namespace Model\Services;

use Model\Services\SequenceRepository;
use Model\Services\EventDispatcher;

/**
* Class SequenceManager
*
* @package Model\Services
*
* @property array \Model\Sequence
* @property \Model\Services\SequenceRepository
* @property \Model\Services\EventDispatcher
*/

class SequenceDispatcher
{
    public function __construct( SequenceRepository $sequenceRepo, EventDispatcher $eventDispatcher )
    {
        $this->sequenceRepo = $sequenceRepo;
        $this->eventDispatcher = $eventDispatcher;
    }

    private function getSequences()
    {
        $this->sequences = $this->sequenceRepo->getAllAvailableForCheckout();
    }

    private function checkOutSequence( $sequence_id )
    {
        $this->sequenceRepo->checkOut( $sequence_id );
    }

    private function checkInSequence( $sequence_id )
    {
        $this->sequenceRepo->checkIn( $sequence_id );
    }

    public function dispatch()
    {
        $this->getSequences();

        foreach ( $this->sequences as $sequence ) {
            $this->checkOutSequence( $sequence->id );
            $event_ids = $this->eventRepo->get( [ "id" ] , [ "sequence_id" => $sequence_id ], "raw" ] );
            $this->checkInSequence( $sequence->id );
        }
    }
}
