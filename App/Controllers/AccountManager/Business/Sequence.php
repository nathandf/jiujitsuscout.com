<?php

namespace Controllers\AccountManager\Business;

use Core\Controller;

class Sequence extends Controller
{
    private $accountRepo;
    private $account;
    private $businessRepo;
    private $business;
    private $userRepo;
    private $user;

    public function before()
    {
        // Loading services
        $userAuth = $this->load( "user-authenticator" );
        $accountRepo = $this->load( "account-repository" );
        $accountUserRepo = $this->load( "account-user-repository" );
        $businessRepo = $this->load( "business-repository" );
        $userRepo = $this->load( "user-repository" );
        // If user not validated with session or cookie, send them to sign in
        if ( !$userAuth->userValidate() ) {
            $this->view->redirect( "account-manager/sign-in" );
        }
        // User is logged in. Get the user object from the UserAuthenticator service
        $this->user = $userAuth->getUser();
        // Get AccountUser reference
        $accountUser = $accountUserRepo->getByUserID( $this->user->id );
        // Grab account details
        $this->account = $accountRepo->getByID( $accountUser->account_id );
        // Grab business details
        $this->business = $businessRepo->getByID( $this->user->getCurrentBusinessID() );

        // Verify that this sequence is owned by this business
        $sequenceTemplateRepo = $this->load( "sequence-template-repository" );
        $sequenceTemplates = $sequenceTemplateRepo->getAllByBusinessID( $this->business->id );
        $sequence_template_ids = [];

        foreach ( $sequenceTemplates as $sequenceTemplate ) {
            $sequence_template_ids[] = $sequenceTemplate->id;
        }

        if ( isset( $this->params[ "id" ] ) && !in_array( $this->params[ "id" ], $sequence_template_ids ) ) {
            $this->view->redirect( "account-manager/business/sequences/" );
        }

        $this->view->assign( "account", $this->account );
        $this->view->assign( "user", $this->user );
        $this->view->assign( "business", $this->business );
    }

    public function indexAction()
    {
        if ( !$this->issetParam( "id" ) ) {
            $this->view->redirect( "account-manager/business/sequences/" );
        }

        $input = $this->load( "input" );
        $inputValidator = $this->load( "input-validator" );
        $sequenceTemplateRepo = $this->load( "sequence-template-repository" );
        $eventTemplateRepo = $this->load( "event-template-repository" );
        $emailTemplateRepo = $this->load( "email-template-repository" );
        $textMessageTemplateRepo = $this->load( "text-message-template-repository" );

        $sequenceTemplate = $sequenceTemplateRepo->getByID( $this->params[ "id" ] );
        $events = $eventTemplateRepo->getAllBySequenceTemplateID( $sequenceTemplate->id );

        $event_template_ids = [];

        // Get all event email and message templates and create an array of event
        // template ids
        foreach ( $events as $event ) {
            $event_template_ids[] = $event->id;
            switch ( $event->event_type_id ) {
                case 1:
                    $event->template = $emailTemplateRepo->getByID(
                        $event->email_template_id
                    );
                    break;
                case 2:
                    $event->template = $textMessageTemplateRepo->getByID(
                        $event->text_message_template_id
                    );
                    break;
                default:
                    $event->template = null;
                    break;
            }
        }

        if ( $input->exists() && $input->issetField( "bump" ) && $inputValidator->validate(
                $input,
                [
                    "token" => [
                        "equals-hidden" => $this->session->getSession( "csrf-token" ),
                        "required" => true
                    ],
                    "direction" => [
                        "required" => true,
                        "in_array" => [ "up", "down" ]
                    ],
                    "event_template_id" => [
                        "required" => true,
                        "in_array" => $event_template_ids,
                    ]
                ],
                "bump"
            )
        ) {
            $eventTemplateRepo->bumpPlacementByID(
                $input->get( "event_template_id" ),
                $input->get( "direction" )
            );

            $this->session->addFlashMessage( "Event moved " . $input->get( "direction" ) . "." );
            $this->session->setFlashMessages();

            $this->view->redirect( "account-manager/business/sequence/" . $this->params[ "id" ] . "/#event" . $input->get( "event_template_id" ) );
        }

        $this->view->assign( "events", $events );
        $this->view->assign( "sequence", $sequenceTemplate );
        $this->view->assign( "csrf_token", $this->session->generateCSRFToken() );
        $this->view->assign( "flash_messages", $this->session->getFlashMessages() );

        $this->view->setTemplate( "account-manager/business/sequence/home.tpl" );
        $this->view->render( "App/Views/AccountManager/Business.php" );
    }

    public function newAction()
    {
        if ( $this->issetParam( "id" ) ) {
            $this->view->redirect( "account-manager/business/sequence/" . $this->params[ "id" ] . "/" );
        }

        $input = $this->load( "input" );
        $inputValidator = $this->load( "input-validator" );

        if ( $input->exists() && $input->issetField( "create_sequence" ) && $inputValidator->validate(
            $input,
            [
                "token" => [
                    "equals-hidden" => $this->session->getSession( "csrf-token" ),
                    "required" => true
                ],
                "name" => [
                    "required" => true
                ],
                "description" => [
                    "required" => true
                ]
            ],
            "create_sequence"
            )
        ) {
            $sequenceTemplateRepo = $this->load( "sequence-template-repository" );
            $sequenceTemplate = $sequenceTemplateRepo->create(
                $this->business->id,
                $input->get( "name" ),
                $input->get( "description" )
            );

            $this->view->redirect( "account-manager/business/sequence/" . $sequenceTemplate->id . "/add-event" );
        }

        $this->view->setErrorMessages( $inputValidator->getErrors() );
        $this->view->assign( "csrf_token", $this->session->generateCSRFToken() );

        $this->view->setTemplate( "account-manager/business/sequence/new.tpl" );
        $this->view->render( "App/Views/AccountManager/Business.php" );
    }

    public function addEventAction()
    {
        if ( !$this->issetParam( "id" ) ) {
            $this->view->redirect( "account-manager/business/sequences/" );
        }

        $input = $this->load( "input" );
        $inputValidator = $this->load( "input-validator" );
        $sequenceTemplateRepo = $this->load( "sequence-template-repository" );
        $eventTypeRepo = $this->load( "event-type-repository" );
        $eventTemplateRepo = $this->load( "event-template-repository" );
        $emailTemplateRepo = $this->load( "email-template-repository" );
        $textMessageTemplateRepo = $this->load( "text-message-template-repository" );

        $sequenceTemplate = $sequenceTemplateRepo->getByID( $this->params[ "id" ] );
        $eventTypes = $eventTypeRepo->getAll();
        $event_type_ids = [];

        foreach ( $eventTypes as $eventType ) {
            $event_type_ids[] = $eventType->id;
        }

        $emailTemplates = $emailTemplateRepo->getAllByBusinessID( $this->business->id );
        $email_template_ids = [];

        foreach ( $emailTemplates as $emailTemplate ) {
            $email_template_ids[] = $emailTemplate->id;
        }

        $textMessageTemplates = $textMessageTemplateRepo->getAllByBusinessID( $this->business->id );
        $text_message_template_ids = [];

        foreach ( $textMessageTemplates as $textMessageTemplate ) {
            $text_message_template_ids[] = $textMessageTemplate->id;
        }

        if ( $input->exists() && $input->issetField( "add_event" ) && $inputValidator->validate(
            $input,
            [
                "token" => [
                    "equals-hidden" => $this->session->getSession( "csrf-token" ),
                    "required" => true
                ],
                "event_type_id" => [
                    "requried" => true,
                    "in_array" => $event_type_ids
                ],
                "template_id" => [
                    "required" => true,
                    "numeric" => true
                ],
                "add_wait_duration" => [
                    "in_array" => [ "true", "false" ]
                ],
                "wait_duration" => [
                    "numeric" => true
                ],
                "wait_duration_interval" => [
                    "in_array" => [ "hours", "days", "months" ]
                ]
            ],
            "add_event"
            )
        ) {
            $wait_duration = 0;

            if ( $input->get( "add_wait_duration" ) == "true" ) {
                // Calculate wait duration in seconds
                switch ( $input->get( "wait_duration_interval" ) ) {
                    case "hours":
                        $wait_duration = $input->get( "wait_duration" ) * 60 * 60;
                        break;
                    case "days":
                        $wait_duration = $input->get( "wait_duration" ) * 60 * 60 * 24;
                        break;
                    case "months":
                        $wait_duration = $input->get( "wait_duration" ) * 60 * 60 * 24 * 30;
                        break;
                }
            }

            switch ( $input->get( "event_type_id" ) ) {
                // Email
                case 1:
                    $eventTemplateRepo->create(
                        $sequenceTemplate->id,
                        $input->get( "event_type_id" ),
                        $input->get( "template_id" ),
                        null,
                        $wait_duration
                    );
                    break;
                // Text Message
                case 2:
                    $eventTemplateRepo->create(
                        $sequenceTemplate->id,
                        $input->get( "event_type_id" ),
                        null,
                        $input->get( "template_id" ),
                        $wait_duration
                    );
                    break;
                default:
                    break;
            }

            $this->session->addFlashMessage( "Event Created" );
            $this->session->setFlashMessages();

            if ( $input->get( "add_another_event" ) == "true" ) {
                $this->view->redirect( "account-manager/business/sequence/" . $this->params[ "id" ] . "/add-event" );
            }

            $this->view->redirect( "account-manager/business/sequence/" . $this->params[ "id" ] . "/" );
        }

        $this->view->assign( "emailTemplates", $emailTemplates );
        $this->view->assign( "textMessageTemplates", $textMessageTemplates );
        $this->view->assign( "sequence", $sequenceTemplate );
        $this->view->assign( "eventTypes", $eventTypes );

        $this->view->assign( "csrf_token", $this->session->generateCSRFToken() );
        $this->view->assign( "flash_messages", $this->session->getFlashMessages() );

        $this->view->setTemplate( "account-manager/business/sequence/add-event.tpl" );
        $this->view->render( "App/Views/AccountManager/Business.php" );
    }

    public function editAction()
    {
        if ( !$this->issetParam( "id" ) ) {
            $this->view->redirect( "account-manager/business/sequences/" );
        }

        $input = $this->load( "input" );
        $inputValidator = $this->load( "input-validator" );
        $sequenceTemplateRepo = $this->load( "sequence-template-repository" );

        $sequenceTemplate = $sequenceTemplateRepo->getByID( $this->params[ "id" ] );

        if ( $input->exists() && $input->issetField( "update_sequence" ) && $inputValidator->validate(
                $input,
                [
                    "token" => [
                        "equals-hidden" => $this->session->getSession( "csrf-token" ),
                        "required" => true
                    ],
                    "name" => [
                        "required" => true
                    ],
                    "description" => [
                        "required" => true
                    ]
                ],
                "update_sequence"
            )
        ) {
            $this->session->addFlashMessage( "Sequence updated" );
            $this->session->setFlashMessages();
            $sequenceTemplateRepo->updateByID( $this->params[ "id" ], $input->get( "name" ), $input->get( "description" ) );
            $this->view->redirect( "account-manager/business/sequence/" . $this->params[ "id" ] . "/edit" );
        }

        $this->view->assign( "sequence", $sequenceTemplate );
        $this->view->assign( "csrf_token", $this->session->generateCSRFToken() );
        $this->view->assign( "flash_messages", $this->session->getFlashMessages() );

        $this->view->setTemplate( "account-manager/business/sequence/edit.tpl" );
        $this->view->render( "App/Views/AccountManager/Business.php" );
    }
}
