<?php

namespace Model\Services;

use Model\Services\EventEmailRepository;
use Model\Services\EmailRepository;
use Contracts\MailerInterface;

/**
* @package Model\Services
*
* @property Model\Services\EventEmailRepository
* @property Model\Services\EmailRepository
* @property Contracts\MailerInterface
*/

class EventEmailDispatcher
{

    public function __construct( EventEmailRepository $eventEmailRepo, EmailRepository $emailRepo, MailerInterface $mailer )
    {
        $this->eventEmailRepo = $eventEmailRepo;
        $this->emailRepo = $emailRepo;
        $this->mailer = $mailer;
    }

    /**
    * @param array event_ids
    */

    public function dispatch( $event_id )
    {
        $eventEmail = $this->eventEmailRepo->getByEventID( $event_id );
        $email = $this->emailRepo->getByID( $eventEmail->email_id );
        // TODO Send email with mailer
    }

}
