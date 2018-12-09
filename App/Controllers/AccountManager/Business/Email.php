<?php

namespace Controllers\AccountManager\Business;

use Core\Controller;

class Email extends Controller
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

        $this->view->assign( "account", $this->account );
        $this->view->assign( "user", $this->user );
        $this->view->assign( "business", $this->business );
    }

    public function indexAction()
    {
        if ( !$this->issetParam( "id" ) ) {
            $this->view->redirect( "account-manager/business/emails/" );
        }

        $this->view->redirect( "account-manager/business/email/" . $this->params[ "id" ] . "/edit" );
    }

    public function editAction()
    {
        if ( !$this->issetParam( "id" ) ) {
            $this->view->redirect( "account-manager/business/emails/" );
        }

        $input = $this->load( "input" );
        $inputValidator = $this->load( "input-validator" );
        $emailRepo = $this->load( "email-repository" );

        $email = $emailRepo->getByID( $this->params[ "id" ] );


        if ( $input->exists() && $input->issetField( "update_email" ) && $inputValidator->validate(
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
                "subject" => [
                    "required" => true,
                ],
                "body" => [
                    "required" => true
                ]
            ],
            "create_email"
            )
        ) {
            $emailRepo->updateByID(
                $this->params[ "id" ],
                $input->get( "name" ),
                $input->get( "description" ),
                $input->get( "subject" ),
                $input->get( "body" )
            );

            $this->session->addFlashMessage( "Email Updated" );
            $this->session->setFlashMessages();
            $this->view->redirect( "account-manager/business/email/" . $email->id . "/" );
        }

        $this->view->assign( "email", $email );

        $this->view->setErrorMessages( $inputValidator->getErrors() );
        $this->view->assign( "csrf_token", $this->session->generateCSRFToken() );
        $this->view->setFlashMessages( $this->session->getFlashMessages( "flash_messages" ) );

        $this->view->setTemplate( "account-manager/business/email/edit.tpl" );
        $this->view->render( "App/Views/AccountManager/Business.php" );

    }

    public function newAction()
    {
        if ( $this->issetParam( "id" ) ) {
            $this->view->redirect( "account-manager/business/email/" . $this->params[ "id" ] . "/" );
        }

        $input = $this->load( "input" );
        $inputValidator = $this->load( "input-validator" );

        if ( $input->exists() && $input->issetField( "create_email" ) && $inputValidator->validate(
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
                "subject" => [
                    "required" => true,
                ],
                "body" => [
                    "required" => true
                ]
            ],
            "create_email"
            )
        ) {
            $emailRepo = $this->load( "email-repository" );
            $email = $emailRepo->create(
                $this->business->id,
                $input->get( "name" ),
                $input->get( "description" ),
                $input->get( "subject" ),
                $input->get( "body" )
            );

            $this->view->redirect( "account-manager/business/email/" . $email->id . "/" );
        }

        $this->view->setErrorMessages( $inputValidator->getErrors() );
        $this->view->assign( "csrf_token", $this->session->generateCSRFToken() );

        $this->view->setTemplate( "account-manager/business/email/new.tpl" );
        $this->view->render( "App/Views/AccountManager/Business.php" );
    }

}
