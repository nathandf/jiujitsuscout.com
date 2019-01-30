<?php

namespace Model\Services;

use Model\Services\SequenceRepository;
use Model\Services\EventRepository;
use Model\Services\SequenceTemplateRepository;
use Model\Services\EventTemplateRepository;
use Model\Services\TextMessageTemplateRepository;
use Model\Services\EmailTemplateRepository;
use Model\Services\EventEmailRepository;
use Model\Services\EventTextMessageRepository;
use Model\Services\TextMessageRepository;
use Model\Services\EmailRepository;

/**
* Class SequenceManager
*
* @package Model\Services
*
* @property \Model\Services\SequenceRepository
* @property \Model\Services\EventRepository
* @property \Model\Services\SequenceTemplateRepository
* @property \Model\Services\EventTemplateRepository
* @property \Model\Services\TextMessageTemplateRepository
* @property \Model\Services\EmailTemplateRepository
* @property \Model\Services\EventEmailRepository
* @property \Model\Services\EventTextMessageRepository
* @property \Model\Services\TextMessageRepository
* @property \Model\Services\EmailRepository
*/

class SequenceBuilder
{
    private $sender_name;
    private $sender_email;
    private $sender_phone_number;
    private $recipient_name;
    private $recipient_email;
    private $recipient_phone_number;
    public $sequence;
    public $error_messages = [];
    private $business_id = null;
    private $prospect_id = null;
    private $member_id = null;
    private $sequence_template_sequence = null;


    public function __construct(
        SequenceRepository $sequenceRepo,
        EventRepository $eventRepo,
        SequenceTemplateRepository $sequenceTemplateRepo,
        EventTemplateRepository $eventTemplateRepo,
        TextMessageTemplateRepository $textMessageTemplateRepo,
        EmailTemplateRepository $emailTemplateRepo,
        EventEmailRepository $eventEmailRepo,
        EventTextMessageRepository $eventTextMessageRepo,
        TextMessageRepository $textMessageRepo,
        EmailRepository $emailRepo,
        BusinessSequenceRepository $businessSequenceRepo,
        ProspectSequenceRepository $prospectSequenceRepo,
        MemberSequenceRepository $memberSequenceRepo,
        SequenceTemplateSequenceRepository $sequenceTemplateSequenceRepo
    ) {
        $this->sequenceRepo = $sequenceRepo;
        $this->eventRepo = $eventRepo;
        $this->sequenceTemplateRepo = $sequenceTemplateRepo;
        $this->eventTemplateRepo = $eventTemplateRepo;
        $this->textMessageTemplateRepo = $textMessageTemplateRepo;
        $this->emailTemplateRepo = $emailTemplateRepo;
        $this->eventEmailRepo = $eventEmailRepo;
        $this->eventTextMessageRepo = $eventTextMessageRepo;
        $this->textMessageRepo = $textMessageRepo;
        $this->emailRepo = $emailRepo;
        $this->businessSequenceRepo = $businessSequenceRepo;
        $this->prospectSequenceRepo = $prospectSequenceRepo;
        $this->memberSequenceRepo = $memberSequenceRepo;
        $this->sequenceTemplateSequenceRepo = $sequenceTemplateSequenceRepo;

    }

    private function addErrorMessage( $message )
    {
        $this->error_messages[] = $message;
    }

    public function getErrorMessages()
    {
        return $this->error_messages;
    }

    public function setRecipientName( $recipient_name )
    {
        $this->recipient_name = $recipient_name;
        return $this;
    }

    public function getRecipientName()
    {
        if ( !isset( $this->recipient_name ) ) {
            $this->addErrorMessage( "Recipient Name required" );
        }

        return $this->recipient_name;
    }

    public function setRecipientPhoneNumber( $recipient_phone_number )
    {
        $this->recipient_phone_number = $recipient_phone_number;
        return $this;
    }

    public function getRecipientPhoneNumber()
    {
        if ( !isset( $this->recipient_phone_number ) ) {
            $this->addErrorMessage( "Recipient Phone Number required" );
        }

        return $this->recipient_phone_number;
    }

    public function setRecipientEmail( $recipient_email )
    {
        $this->recipient_email = $recipient_email;

        return $this;
    }

    public function getRecipientEmail()
    {
        if ( !isset( $this->recipient_email ) ) {
            $this->addErrorMessage( "Recipient Email required" );
        }

        return $this->recipient_email;
    }

    public function setSenderName( $sender_name )
    {
        $this->sender_name = $sender_name;
        return $this;
    }

    public function getSenderName()
    {
        if ( !isset( $this->sender_name ) ) {
            $this->addErrorMessage( "Sender Name required" );
        }

        return $this->sender_name;
    }

    public function setSenderPhoneNumber( $sender_phone_number )
    {
        $this->sender_phone_number = $sender_phone_number;
        return $this;
    }

    public function getSenderPhoneNumber()
    {
        if ( !isset( $this->sender_phone_number ) ) {
            $this->addErrorMessage( "Sender Phone Number required" );
        }

        return $this->sender_phone_number;
    }

    public function setSenderEmail( $sender_email )
    {
        $this->sender_email = $sender_email;

        return $this;
    }

    public function getSenderEmail()
    {
        if ( !isset( $this->sender_email ) ) {
            $this->addErrorMessage( "Sender Email required" );
        }

        return $this->sender_email;
    }

    private function setSequence( $sequence )
    {
        $this->sequence = $sequence;
        return $this;
    }

    public function setBusinessID( $business_id )
    {
        $this->business_id = $business_id;
        return $this;
    }

    public function setProspectID( $prospect_id )
    {
        $this->prospect_id = $prospect_id;
        return $this;
    }

    public function setMemberID( $member_id )
    {
        $this->member_id = $member_id;
        return $this;
    }

    public function getSequence()
    {
        if ( !isset( $this->sequence ) ) {
            throw new \Exception( "No sequence has been created." );
        }

        return $this->sequence;
    }

    private function validateEmailContactRequirements()
    {
        $this->getRecipientName();
        $this->validateEmail( $this->getRecipientEmail() );
        $this->getSenderName();
        $this->validateEmail( $this->getSenderEmail() );
    }

    private function validateTextMessageContactRequirements()
    {
        $this->getRecipientPhoneNumber();
        $this->getSenderPhoneNumber();
    }

    private function validateEmail( $email )
    {
        if ( !filter_var( $email, FILTER_VALIDATE_EMAIL ) ) {
            if ( $email == "" ) {
                $this->addErrorMessage( "A valid email is requried to be added to this sequence." );
                return;
            }
            $this->addErrorMessage( "'{$email}' is not a valid email address" );
        }

        return;
    }

    public function buildFromSequenceTemplate( $sequence_template_id )
    {
        $sequenceTemplate = $this->sequenceTemplateRepo->get( [ "*" ], [ "id" => $sequence_template_id ], "single" );
        $eventTemplates = $this->eventTemplateRepo->get( [ "*" ], [ "sequence_template_id" => $sequenceTemplate->id ] );

        // Get the event types that will be built for this sequence
        $eventTypes = [];
        foreach ( $eventTemplates as $eventTemplate ) {
            if ( !in_array( $eventTemplate->event_type_id, $eventTypes ) ) {
                $eventTypes[] = $eventTemplate->event_type_id;
            }
        }

        // Check if the required contact information is required for each event type
        foreach ( $eventTypes as $type ) {
            switch ( $type ) {
                case 1:
                    $this->validateEmailContactRequirements();
                    break;
                case 2:
                    $this->validateTextMessageContactRequirements();
                    break;
            }
        }

        // If requried contact information is no available, return false
        if ( !empty( $this->getErrorMessages() ) ) {
            return false;
        }

        // Create the sequence
        $sequence = $this->sequenceRepo->insert([
            "checked_out" => 0
        ]);

        $this->setSequence( $sequence );

        $time = time();

        foreach ( $eventTemplates as $eventTemplate ) {
            switch ( $eventTemplate->event_type_id ) {
                case 1:
                    $emailTemplate = $this->emailTemplateRepo->get( [ "*" ], [ "id" => $eventTemplate->email_template_id ], "single" );

                    $event = $this->eventRepo->insert([
                        "sequence_id" => $sequence->id,
                        "event_type_id" => $eventTemplate->event_type_id,
                        "time" => $time
                    ]);

                    $email = $this->emailRepo->insert([
                        "subject" => $emailTemplate->subject,
                        "body" => $emailTemplate->body,
                        "recipient_email" => $this->getRecipientEmail(),
                        "recipient_name" => $this->getRecipientName(),
                        "sender_name" => $this->getSenderName(),
                        "sender_email" => $this->getSenderEmail()
                    ]);

                    $eventEmail = $this->eventEmailRepo->insert([
                        "event_id" => $event->id,
                        "email_id" => $email->id
                    ]);

                    // Set the new time based on the wait duration of the current eventTemplate
                    $time = $time + $eventTemplate->wait_duration;

                    break;
                case 2:
                    $textMessageTemplate = $this->textMessageTemplateRepo->get( [ "*" ], [ "id" => $eventTemplate->text_message_template_id ], "single" );

                    $event = $this->eventRepo->insert([
                        "sequence_id" => $sequence->id,
                        "event_type_id" => $eventTemplate->event_type_id,
                        "time" => $time
                    ]);

                    $textMessage = $this->textMessageRepo->insert([
                        "body" => $textMessageTemplate->body,
                        "sender_phone_number" => $this->getSenderPhoneNumber(),
                        "recipient_phone_number" => $this->getRecipientPhoneNumber(),
                    ]);

                    $eventTextMessage = $this->eventTextMessageRepo->insert([
                        "event_id" => $event->id,
                        "text_message_id" => $textMessage->id
                    ]);

                    // Set the new time based on the wait duration of the current eventTemplate
                    $time = $time + $eventTemplate->wait_duration;

                    break;
            }
        }

        if ( !is_null( $this->business_id ) && !is_null( $sequence->id ) ) {
            $this->businessSequenceRepo->insert([
                "business_id" => $this->business_id,
                "sequence_id" => $sequence->id
            ]);
        }

        if ( !is_null( $this->prospect_id ) && !is_null( $sequence->id ) ) {
            $this->prospectSequenceRepo->insert([
                "prospect_id" => $this->prospect_id,
                "sequence_id" => $sequence->id
            ]);
        }

        if ( !is_null( $this->member_id ) && !is_null( $sequence->id ) ) {
            $this->memberSequenceRepo->insert([
                "member_id" => $this->member_id,
                "sequence_id" => $sequence->id
            ]);
        }

        if ( !is_null( $sequence_template_id ) && !is_null( $sequence->id ) ) {
            $this->sequenceTemplateSequenceRepo->insert([
                "sequence_template_id" => $sequence_template_id,
                "sequence_id" => $sequence->id
            ]);
        }


        return true;
    }
}
