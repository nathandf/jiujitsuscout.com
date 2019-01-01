<?php

namespace Controllers\AccountManager\Business;

use Core\Controller;

class TextMessage extends Controller
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
        $accountUser = $accountUserRepo->get( [ "*" ], [ "user_id" => $this->user->id ], "single" );
        // Grab account details
        $this->account = $accountRepo->get( [ "*" ], [ "id" => $accountUser->account_id ], "single" );
        // Grab business details
        $this->business = $businessRepo->getByID( $this->user->getCurrentBusinessID() );

        // Verify that this text message template is owned by this business
        $textMessageTemplateRepo = $this->load( "text-message-template-repository" );
        $textMessageTemplates = $textMessageTemplateRepo->getAllByBusinessID( $this->business->id );
        $text_message_template_ids = [];

        foreach ( $textMessageTemplates as $textMessageTemplate ) {
            $text_message_template_ids[] = $textMessageTemplate->id;
        }

        if ( isset( $this->params[ "id" ] ) && !in_array( $this->params[ "id" ], $text_message_template_ids ) ) {
            $this->view->redirect( "account-manager/business/text-messages/" );
        }

        $this->view->assign( "account", $this->account );
        $this->view->assign( "user", $this->user );
        $this->view->assign( "business", $this->business );
    }

    public function indexAction()
    {
        if ( !$this->issetParam( "id" ) ) {
            $this->view->redirect( "account-manager/business/text-messages/" );
        }

        $this->view->redirect( "account-manager/business/text-message/" . $this->params[ "id" ] . "/edit" );
    }

    public function editAction()
    {
        if ( !$this->issetParam( "id" ) ) {
            $this->view->redirect( "account-manager/business/text-messages/" );
        }

        $input = $this->load( "input" );
        $inputValidator = $this->load( "input-validator" );
        $textMessageTemplateRepo = $this->load( "text-message-template-repository" );

        $textMessageTemplate = $textMessageTemplateRepo->getByID( $this->params[ "id" ] );


        if ( $input->exists() && $input->issetField( "update_text_message" ) && $inputValidator->validate(
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
                ],
                "body" => [
                    "required" => true
                ]
            ],
            "create_text_message"
            )
        ) {
            $textMessageTemplateRepo->updateByID(
                $this->params[ "id" ],
                $input->get( "name" ),
                $input->get( "description" ),
                $input->get( "body" )
            );

            $this->session->addFlashMessage( "Text Message Updated" );
            $this->session->setFlashMessages();
            $this->view->redirect( "account-manager/business/text-message/" . $textMessageTemplate->id . "/" );
        }

        $this->view->assign( "textMessage", $textMessageTemplate );

        $this->view->setErrorMessages( $inputValidator->getErrors() );
        $this->view->assign( "csrf_token", $this->session->generateCSRFToken() );
        $this->view->setFlashMessages( $this->session->getFlashMessages( "flash_messages" ) );

        $this->view->setTemplate( "account-manager/business/text-message/edit.tpl" );
        $this->view->render( "App/Views/AccountManager/Business.php" );

    }

    public function newAction()
    {
        if ( $this->issetParam( "id" ) ) {
            $this->view->redirect( "account-manager/business/text-message/" . $this->params[ "id" ] . "/" );
        }

        $input = $this->load( "input" );
        $inputValidator = $this->load( "input-validator" );

        if ( $input->exists() && $input->issetField( "create_text_message" ) && $inputValidator->validate(
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
                ],
                "body" => [
                    "required" => true
                ]
            ],
            "create_text_message"
            )
        ) {
            $textMessageTemplateRepo = $this->load( "text-message-template-repository" );
            $textMessageTemplate = $textMessageTemplateRepo->create(
                $this->business->id,
                $input->get( "name" ),
                $input->get( "description" ),
                $input->get( "body" )
            );

            $this->view->redirect( "account-manager/business/text-message/" . $textMessageTemplate->id . "/" );
        }

        $this->view->setErrorMessages( $inputValidator->getErrors() );
        $this->view->assign( "csrf_token", $this->session->generateCSRFToken() );

        $this->view->setTemplate( "account-manager/business/text-message/new.tpl" );
        $this->view->render( "App/Views/AccountManager/Business.php" );
    }

}
