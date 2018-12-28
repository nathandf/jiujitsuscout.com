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
    public function __construct( EventTextMessageRepository $eventTextMessageRepo, TextMessageRepository $textMessageRepo, SMSMessagerInterface $smsMessager )
    {
        $this->eventTextMessageRepo = $eventTextMessageRepo;
        $this->textMessageRepo = $textMessageRepo;
        $this->smsMessager = $smsMessager;
    }

    /**
    * @param array event_ids
    */

    public function dispatch( $event_id )
    {
        $eventTextMessage = $this->eventTextMessageRepo->getByEventID( $event_id );
        $textMessage = $this->textMessageRepo->getByID( $eventTextMessage->text_message_id );
        echo $textMessage->body;
    }
}
