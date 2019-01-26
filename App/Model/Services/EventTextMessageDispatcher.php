<?php

namespace Model\Services;

use Model\Services\EventTextMessageRepository;
use Model\Services\TextMessageRepository;
use Contracts\SMSMessagerInterface;
/**
 * @package Model\Services
 *
 * @property Model\Services\EventTextMessageRepository
 * @property Model\Services\TextMessageRepository
 * @property Contracts\SMSMessagerInterface
 */

class EventTextMessageDispatcher
{
    public function __construct(
        EventTextMessageRepository $eventTextMessageRepo,
        TextMessageRepository $textMessageRepo,
        SMSMessagerInterface $smsMessager
    ) {
        $this->eventTextMessageRepo = $eventTextMessageRepo;
        $this->textMessageRepo = $textMessageRepo;
        $this->smsMessager = $smsMessager;
    }

    /**
    * @param array event_ids
    */
    public function dispatch( $event_id )
    {
        $eventTextMessage = $this->eventTextMessageRepo->get( [ "*" ], [ "event_id" => $event_id ], "single" );
        $textMessage = $this->textMessageRepo->get( [ "*" ], [ "id" => $eventTextMessage->text_message_id ], "single" );
        // TODO Send Text Message
        $this->eventTextMessageRepo->delete( [ "event_id" => $event_id ] );
    }
}
