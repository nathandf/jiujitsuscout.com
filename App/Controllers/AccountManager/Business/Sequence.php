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
        $taskRepo = $this->load( "task-repository" );
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

        $sequenceTemplateRepo = $this->load( "sequence-template-repository" );
        $eventRepo = $this->load( "event-repository" );

        $sequenceTemplate = $sequenceTemplateRepo->getByID( $this->params[ "id" ] );
        $events = $eventRepo->getAllBySequenceID( $sequenceTemplate->id );

        $this->view->assign( "events", $events );
        $this->view->assign( "sequence", $sequenceTemplate );
        $this->view->assign( "csrf_token", $this->session->generateCSRFToken() );

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

        $sequenceTemplateRepo = $this->load( "sequence-template-repository" );
        $eventTypeRepo = $this->load( "event-type-repository" );
        $eventRepo = $this->load( "event-repository" );

        $sequenceTemplate = $sequenceTemplateRepo->getByID( $this->params[ "id" ] );
        $eventTypes = $eventTypeRepo->getAll();

        $this->view->assign( "sequence", $sequenceTemplate );
        $this->view->assign( "eventTypes", $eventTypes );

        $this->view->assign( "csrf_token", $this->session->generateCSRFToken() );

        $this->view->setTemplate( "account-manager/business/sequence/add-event.tpl" );
        $this->view->render( "App/Views/AccountManager/Business.php" );
    }
}
