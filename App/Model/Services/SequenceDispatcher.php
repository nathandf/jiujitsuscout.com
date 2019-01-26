<?php

namespace Model\Services;

use Model\Services\SequenceRepository;
use Model\Services\SequenceDestroyer;
use Model\Services\EventDispatcher;
use Model\Services\EventRepository;

/**
* Class SequenceDispatcher
*
* @package Model\Services
*
* @property array \Model\Sequence
* @property \Model\Services\SequenceRepository
* @property \Model\Services\SequenceDestroyer
* @property \Model\Services\EventDispatcher
* @property \Model\Services\EventRepository
*/

class SequenceDispatcher
{
    public function __construct(
        SequenceRepository $sequenceRepo,
        SequenceDestroyer $sequenceDestroyer,
        EventDispatcher $eventDispatcher,
        EventRepository $eventRepo
    ) {
        $this->sequenceRepo = $sequenceRepo;
        $this->sequenceDestroyer = $sequenceDestroyer;
        $this->eventDispatcher = $eventDispatcher;
        $this->eventRepo = $eventRepo;
    }

    private function getSequences()
    {
        return $this->sequenceRepo->getAllAvailableForCheckout();
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
        $sequences = $this->getSequences();

        foreach ( $sequences as $sequence ) {
            $this->checkOutSequence( $sequence->id );
            $event_ids = $this->eventRepo->get( [ "id" ], [ "sequence_id" => $sequence->id ], "raw" );

            // If no events exist, delete this sequence and all its references
            if ( empty( $event_ids ) ) {
                $this->sequenceDestroyer->destroy( $sequence->id );
                continue;
            }

            // If events exist, dispatch the sequence
            $this->eventDispatcher->dispatch( $event_ids );
            $this->checkInSequence( $sequence->id );
        }
    }
}
