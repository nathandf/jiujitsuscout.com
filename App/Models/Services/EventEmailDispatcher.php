<?php

namespace Models\Services;

use Models\Services\EventEmailRepository;
use Models\Services\EmailRepository;
use Contracts\MailerInterface;

/**
* @package Models\Services
*
* @property Models\Services\EventEmailRepository
* @property Models\Services\EmailRepository
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
