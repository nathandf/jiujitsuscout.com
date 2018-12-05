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
        $this->view->redirect( "account-manager/business/assets/facebook-pixel" );
    }

    public function websiteAction()
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
                    "website" => [
                        "name" => "Website URL",
                        "max" => 50
                    ]
                ],

                "website" /* error index */
            ) )
        {
            $businessRepo->updateWebsiteByID( $this->business->id, trim( $input->get( "website" ) ) );
            $this->view->redirect( "account-manager/business/assets/website" );
        }

        $this->view->assign( "csrf_token", $this->session->generateCSRFToken() );
        $this->view->setErrorMessages( $inputValidator->getErrors() );

        $this->view->setTemplate( "account-manager/business/assets/website.tpl" );
        $this->view->render( "App/Views/AccountManager/Assets.php" );
    }

    public function facebookPixelAction()
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
            $this->view->redirect( "account-manager/business/assets/facebook-pixel" );
        }

        $this->view->assign( "csrf_token", $this->session->generateCSRFToken() );
        $this->view->setErrorMessages( $inputValidator->getErrors() );

        $this->view->setTemplate( "account-manager/business/assets/facebook-pixel.tpl" );
        $this->view->render( "App/Views/AccountManager/Assets.php" );
    }
}
