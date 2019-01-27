<?php

namespace Model\Services;

use \Model\Services\EventRepository;
use \Model\Services\EventEmailRepository;
use \Model\Services\EventTextMessageRepository;

/**
* Class SequenceDestroyer
*
* @package Model\Services
*
* @property \Model\Services\EventRepository
* @property \Model\Services\EventEmailRepository
* @property \Model\Services\EventTextMessageRepository
*/

class EventDestroyer
{
    public function __construct(
        EventRepository $eventRepo,
        EventEmailRepository $eventEmailRepo,
        EventTextMessageRepository $eventTextMessageRepo
    ) {
        $this->eventRepo = $eventRepo;
        $this->eventEmailRepo = $eventEmailRepo;
        $this->eventTextMessageRepo = $eventTextMessageRepo;
    }

    public function destroy( $event_id )
    {
        $this->eventRepo->delete( [ "id" ], [ $event_id ] );
        $this->eventEmailRepo->delete( [ "event_id" ], [ $event_id ] );
        $this->eventTextMessageRepo->delete( [ "event_id" ], [ $event_id ] );
    }

    public function destroyBySequenceID( $sequence_id )
    {
        // Only delete incomplete events
        $events = $this->eventRepo->get( [ "*" ], [ "sequence_id" => $sequence_id, "comlete" => 0 ] );

        foreach ( $events as $event ) {
            $this->destroy( $event->id );
        }
    }
}
