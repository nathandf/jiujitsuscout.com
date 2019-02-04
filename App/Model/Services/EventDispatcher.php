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
    public $all_events_dispatched = false;

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
        $event_count = count( $event_ids );
        $e = 0;
        foreach ( $event_ids as $id ) {
            $e++;
            $event = $this->eventRepo->get( [ "*" ], [ "id" => $id ], "single" );
            if ( $event->time <= time() ) {
                switch ( $event->event_type_id ) {
                    case 1:
                        $this->eventEmailDispatcher->dispatch( $event->id );
                        break;
                    case 2:
                        $this->eventTextMessageDispatcher->dispatch( $event->id );
                        break;
                    default:
                        break;
                }

                $this->eventRepo->update( [ "complete" => 1 ], [ "id" => $event->id ] );

                // If the last event is dispatched, update all_events_dispatched to true
                if ( $event_count == $e ) {
                    $this->all_events_dispatched = true;
                }
            }
        }
    }
}
