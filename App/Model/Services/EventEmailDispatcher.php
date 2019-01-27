<?php

namespace Model\Services;

use Model\Services\EventEmailRepository;
use Model\Services\EmailRepository;
use Helpers\EmailBuilderHelper;
use Contracts\MailerInterface;

/**
* @package Model\Services
*
* @property Model\Services\EventEmailRepository
* @property Model\Services\EmailRepository
* @property Helpers\EmailBuilderHelper
* @property Contracts\MailerInterface
*/

class EventEmailDispatcher
{
    public function __construct(
        EventEmailRepository $eventEmailRepo,
        EmailRepository $emailRepo,
        EmailBuilderHelper $emailBuilderHelper,
        MailerInterface $mailer
    ) {
        $this->eventEmailRepo = $eventEmailRepo;
        $this->emailRepo = $emailRepo;
        $this->emailBuilderHelper = $emailBuilderHelper;
        $this->mailer = $mailer;
    }

    /**
    * @param array event_ids
    */
    public function dispatch( $event_id )
    {
        $eventEmail = $this->eventEmailRepo->get( [ "*" ], [ "event_id" => $event_id ], "single" );

        $email = $this->emailRepo->get( [ "*" ], [ "id" => $eventEmail->email_id ], "single" );

        if ( !is_null( $email ) ) {
            // Send email
            $this->mailer->setRecipientName( $email->recipient_name );
            $this->mailer->setRecipientEmailAddress( $email->recipient_email );
            $this->mailer->setSenderName( $email->sender_name );
            $this->mailer->setSenderEmailAddress( $email->sender_email );
            $this->mailer->setContentType( "text/html" );
            $this->mailer->setEmailSubject( $email->subject );

            $this->emailBuilderHelper->prepareEmailBody( $email->body );
            $this->mailer->setEmailBody( $this->emailBuilderHelper->build() );

            $this->mailer->mail();
        }
    }
}
