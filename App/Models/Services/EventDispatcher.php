<?php

namespace Models\Services;

use Models\Services\EventRepository;
use Models\Services\EventEmailDispatcher;
use Models\Services\EventTextMessageDispatcher;

/**
* @package Models\Services
*
* @property Models\Services\EventRepository
* @property Models\Services\EventEmailDispatcher
* @property Models\Services\EventTextMessageDispatcher
*/

class EventDispatcher
{

    public function __construct( EventRepository $eventRepo, EventEmailDispatcher $eventEmailDispatcher, EventTextMessageDispatcher $eventTextMessageDispatcher )
    {
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
            $event = $this->eventRepo->getByID( $id );
            switch ( $event->event_type_id ) {
                case 1:
                    $this->eventEmailDispatcher->dispatch( $event->id );
                    echo "<br>";
                    break;
                case 2:
                    $this->eventTextMessageDispatcher->dispatch( $event->id );
                    echo "<br>";
                    break;
                case 3:
                    echo "Wait" . "<br>";
                    break;
                default:
                    break;
            }
        }
    }

}
