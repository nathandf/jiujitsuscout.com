<?php

namespace Models\Services;

use Models\Services\EventTextMessageRepository;
use Models\Services\TextMessageRepository;
use Contracts\SMSMessagerInterface;
/**
 * @package Models\Services
 *
 * @property Models\Services\EventTextMessageRepository
 * @property Models\Services\TextMessageRepository
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
