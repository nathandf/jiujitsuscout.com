<?php

namespace Model\Services;

use Model\Services\EventRepository;
use Model\Services\EventEmailDispatcher;
use Model\Services\EventTextMessageDispatcher;

/**
* @package Model\Services
*
* @property Model\Services\EventRepository
* @property Model\Services\EventEmailDispatcher
* @property Model\Services\EventTextMessageDispatcher
*/

class EventDispatcher
{
    public function __construct(
        EventRepository $eventRepo,
        EventEmailDispatcher $eventEmailDispatcher,
        EventTextMessageDispatcher $eventTextMessageDispatcher
    ) {
        $this->eventRepo = $eventRepo;
        $this->eventEmailDispatcher = $eventEmailDispatcher;
        $this->eventTextMessageDispatcher = $eventTextMessageDispatcher;
    }

    /**
    * @param array event_ids
    */
    public function dispatch( array $event_ids )
    {
        foreach ( $event_ids as $id ) {
            $event = $this->eventRepo->get( [ "*" ], [ "id" => $id ], "single" );
            if ( $event->time <= time() ) {
                switch ( $event->event_type_id ) {
                    case 1:
                        $this->eventEmailDispatcher->dispatch( $event->id );
                        $this->eventEmailRepo->delete([ "event_id" => $event->id ]);
                        break;
                    case 2:
                        $this->eventTextMessageDispatcher->dispatch( $event->id );
                        $this->eventTextMessageRepo->delete([ "event_id" => $event->id ]);
                        break;
                    default:
                        break;
                }

                $this->eventRepo->update( [ "complete" => 1 ], [ "id" => $event->id ] );
            }
        }
    }
}
