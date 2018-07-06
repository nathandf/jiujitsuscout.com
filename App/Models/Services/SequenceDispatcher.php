<?php

namespace Models\Services;

use Models\Services\SequenceRepository;
use Models\Services\EventDispatcher;

/**
* Class SequenceManager
*
* @package Models\Services
*
* @property array \Models\Sequence
* @property \Models\Services\SequenceRepository
* @property \Models\Services\EventDispatcher
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
      $this->eventDispatcher->dispatch( explode( ",", $sequence->event_ids ) );
      $this->checkInSequence( $sequence->id );
    }
  }

}
