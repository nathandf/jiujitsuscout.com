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

        // Verify that this email template is owned by this business
        $emailTemplateRepo = $this->load( "email-template-repository" );
        $emailTemplates = $emailTemplateRepo->getAllByBusinessID( $this->business->id );
        $email_template_ids = [];

        foreach ( $emailTemplates as $emailTemplate ) {
            $email_template_ids[] = $emailTemplate->id;
        }

        if ( isset( $this->params[ "id" ] ) && !in_array( $this->params[ "id" ], $email_template_ids ) ) {
            $this->view->redirect( "account-manager/business/emails/" );
        }

        // Track with facebook pixel
		$Config = $this->load( "config" );
		$facebookPixelBuilder = $this->load( "facebook-pixel-builder" );

		$facebookPixelBuilder->addPixelID( $Config::$configs[ "facebook" ][ "jjs_pixel_id" ] );
		$this->view->assign( "facebook_pixel", $facebookPixelBuilder->build() );

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
        $emailTemplateRepo = $this->load( "email-template-repository" );
        $imageRepo = $this->load( "image-repository" );
        $videoRepo = $this->load( "video-repository" );

        $emailTemplate = $emailTemplateRepo->getByID( $this->params[ "id" ] );


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
            $emailBuilderHelper = $this->load( "email-builder-helper" );
            $emailBuilderHelper->prepareEmailBody( $input->get( "body" ) );

            $image_ids = $imageRepo->get( [ "id" ], [ "business_id" => $this->business->id ], "raw" );
            $video_ids = $videoRepo->get( [ "id" ], [ "business_id" => $this->business->id ], "raw" );

            // Validate that the images and videos belong to this business
            $image_ids_to_validate = $emailBuilderHelper->getImageIDs();
            $video_ids_to_validate = $emailBuilderHelper->getVideoIDs();

            foreach ( $image_ids_to_validate as $image_id ) {
                if ( !in_array( $image_id, $image_ids ) ) {
                    $emailBuilderHelper->removeImageTagByImageID( $image_id );
                }
            }

            foreach ( $video_ids_to_validate as $video_id ) {
                if ( !in_array( $video_id, $video_ids ) ) {
                    $emailBuilderHelper->removeVideoTagByVideoID( $video_id );
                }
            }

            $emailTemplateRepo->updateByID(
                $this->params[ "id" ],
                $input->get( "name" ),
                $input->get( "description" ),
                $input->get( "subject" ),
                $emailBuilderHelper->getEmailBody()
            );

            $this->session->addFlashMessage( "Email Updated" );
            $this->session->setFlashMessages();
            $this->view->redirect( "account-manager/business/email/" . $emailTemplate->id . "/" );
        }

        $this->view->assign( "email", $emailTemplate );
        $this->view->assign( "images", $imageRepo->get( [ "*" ], [ "business_id" => $this->business->id ] ) );
        $this->view->assign( "videos", $videoRepo->get( [ "*" ], [ "business_id" => $this->business->id ] ) );

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
        $imageRepo = $this->load( "image-repository" );
        $videoRepo = $this->load( "video-repository" );

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
            $emailBuilderHelper = $this->load( "email-builder-helper" );
            $emailBuilderHelper->prepareEmailBody( $input->get( "body" ) );

            $image_ids = $imageRepo->get( [ "id" ], [ "business_id" => $this->business->id ], "raw" );
            $video_ids = $videoRepo->get( [ "id" ], [ "business_id" => $this->business->id ], "raw" );

            // Validate that the images and videos belong to this business
            $image_ids_to_validate = $emailBuilderHelper->getImageIDs();
            $video_ids_to_validate = $emailBuilderHelper->getVideoIDs();

            foreach ( $image_ids_to_validate as $image_id ) {
                if ( !in_array( $image_id, $image_ids ) ) {
                    $emailBuilderHelper->removeImageTagByImageID( $image_id );
                }
            }

            foreach ( $video_ids_to_validate as $video_id ) {
                if ( !in_array( $video_id, $video_ids ) ) {
                    $emailBuilderHelper->removeVideoTagByVideoID( $video_id );
                }
            }

            $emailTemplateRepo = $this->load( "email-template-repository" );
            $emailTemplate = $emailTemplateRepo->create(
                $this->business->id,
                $input->get( "name" ),
                $input->get( "description" ),
                $input->get( "subject" ),
                $emailBuilderHelper->getEmailBody()
            );

            $this->session->addFlashMessage( "Email Created: {$input->get( "name" )}" );
            $this->session->setFlashMessages();

            $this->view->redirect( "account-manager/business/email/" . $emailTemplate->id . "/" );
        }

        $this->view->setErrorMessages( $inputValidator->getErrors() );
        $this->view->assign( "csrf_token", $this->session->generateCSRFToken() );
        $this->view->assign( "images", $imageRepo->get( [ "*" ], [ "business_id" => $this->business->id ] ) );
        $this->view->assign( "videos", $videoRepo->get( [ "*" ], [ "business_id" => $this->business->id ] ) );

        $this->view->setTemplate( "account-manager/business/email/new.tpl" );
        $this->view->render( "App/Views/AccountManager/Business.php" );
    }

}
