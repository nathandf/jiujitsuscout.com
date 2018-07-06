<?php

namespace Controllers\AccountManager\Business;

use Core\Controller;

class Assets extends Controller
{

    public function before()
    {
        // Loading services
        $userAuth = $this->load( "user-authenticator" );
        $accountRepo = $this->load( "account-repository" );
        $accountUserRepo = $this->load( "account-user-repository" );
        $this->businessRepo = $this->load( "business-repository" );
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
        $this->business = $this->businessRepo->getByID( $this->user->getCurrentBusinessID() );

        // Set data for the view
        $this->view->assign( "account", $this->account );
        $this->view->assign( "user", $this->user );
        $this->view->assign( "business", $this->business );
    }

    public function indexAction()
    {
        $this->view->redirect( "account-manager/business/assets/logo" );
    }

    public function logoAction()
    {
        $input = $this->load( "input" );
        $inputValidator = $this->load( "input-validator" );
        $imageManager = $this->load( "image-manager" );
        $config = $this->load( "config" );

        if ( $input->exists() && $input->issetField( "upload_image" ) && $inputValidator->validate(

                $input,

                [
                    "token" => [
                        "equals-hidden" => $this->session->getSession( "csrf-token" ),
                        "required" => true
                    ],
                    "upload_image" => [
                        "required" => true
                    ]

                ],

                "upload_image" /* error index */
            ) )
        {
            if ( $this->business->logo_filename == $config::$configs[ "default_logo" ] ) {
                $imageManager->saveImageTo( "image", "img/uploads/" );
            } else {
                $imageManager->overwriteImage( "image", "img/uploads/", "img/uploads/" . $this->business->logo_filename );
            }

            $this->businessRepo->updateLogoByID( $this->business->id, $imageManager->getNewImageFileName() );
            $this->view->redirect( "account-manager/business/assets/logo" );
        }

        $this->view->assign( "csrf_token", $this->session->generateCSRFToken() );
        $this->view->setErrorMessages( $inputValidator->getErrors() );

        $this->view->setTemplate( "account-manager/business/assets/logo.tpl" );
        $this->view->render( "App/Views/AccountManager/Assets.php" );
    }

    public function trackingCodesAction()
    {
        $input = $this->load( "input" );
        $inputValidator = $this->load( "input-validator" );
        $businessRepo = $this->load( "business-repository" );

        if ( $input->exists() && $inputValidator->validate(

                $input,

                [
                    "token" => [
                        "equals-hidden" => $this->session->getSession( "csrf-token" ),
                        "required" => true
                    ],
                    "facebook_pixel_id" => [
                        "name" => "Facebook Pixel ID",
                        "max" => 50
                    ]
                ],

                "facebook_pixel" /* error index */
            ) )
        {
            $businessRepo->updateFacebookPixelIDByID( trim( $input->get( "facebook_pixel_id" ) ), $this->business->id );
            $this->view->redirect( "account-manager/business/assets/tracking-codes" );
        }

        $this->view->assign( "csrf_token", $this->session->generateCSRFToken() );
        $this->view->setErrorMessages( $inputValidator->getErrors() );

        $this->view->setTemplate( "account-manager/business/assets/tracking-codes.tpl" );
        $this->view->render( "App/Views/AccountManager/Assets.php" );
    }

    public function leadCaptureSiteAction()
    {
        $input = $this->load( "input" );
        $inputValidator = $this->load( "input-validator" );

        if ( $input->exists() && $input->issetField( "site_slug" ) && $inputValidator->validate(

                $input,

                [
                    "token" => [
                        "equals-hidden" => $this->session->getSession( "csrf-token" ),
                        "required" => true
                    ],
                    "site_slug" => [
                        "name" => "Site Slug",
                        "required" => true,
                        "min" => 1,
                        "max" => 50
                    ]
                ],

                "update_site_slug" /* error index */
            ) )
        {
            $this->businessRepo->updateSiteSlugByID( $this->business->id, $input->get( "site_slug" ) );
            $this->view->redirect( "account-manager/business/assets/lead-capture-site" );
        }

        if ( $input->exists() && $inputValidator->validate(
                $input,

                [
                    "token" => [
                        "equals-hidden" => $this->session->getSession( "csrf-token" ),
                        "required" => true
                    ],
                    "update_message" => [
                        "required" => true
                    ],
                    "message" => [
                        "name" => "Message",
                        "max" => 1000
                    ],
                    "title" => [
                        "name" => "Title",
                        "max" => 500
                    ]
                ],

                "update_site_message"
            ) )
        {
            $this->businessRepo->updateSiteMessageByID( $this->business->id, $input->get( "title" ), $input->get( "message" ) );
            $this->view->redirect( "account-manager/business/assets/lead-capture-site" );
        }

        $this->view->assign( "csrf_token", $this->session->generateCSRFToken() );
        $this->view->setErrorMessages( $inputValidator->getErrors() );

        $this->view->setTemplate( "account-manager/business/assets/lead-capture-site.tpl" );
        $this->view->render( "App/Views/AccountManager/Assets.php" );
    }

}
