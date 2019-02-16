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
        $accountUser = $accountUserRepo->get( [ "*" ], [ "user_id" => $this->user->id ], "single" );

        // Grab account details
        $this->account = $accountRepo->get( [ "*" ], [ "id" => $accountUser->account_id ], "single" );

        // Grab business details
        $this->business = $this->businessRepo->getByID( $this->user->getCurrentBusinessID() );

        // Track with facebook pixel
		$Config = $this->load( "config" );
		$facebookPixelBuilder = $this->load( "facebook-pixel-builder" );

		$facebookPixelBuilder->addPixelID( $Config::$configs[ "facebook" ][ "jjs_pixel_id" ] );
		$this->view->assign( "facebook_pixel", $facebookPixelBuilder->build() );

        // Set data for the view
        $this->view->assign( "account", $this->account );
        $this->view->assign( "user", $this->user );
        $this->view->assign( "business", $this->business );
    }

    public function indexAction()
    {
        $this->view->redirect( "account-manager/business/assets/facebook-pixels" );
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

    public function facebookPixelsAction()
    {
        $input = $this->load( "input" );
        $inputValidator = $this->load( "input-validator" );
        $businessRepo = $this->load( "business-repository" );
        $facebookPixelRepo = $this->load( "facebook-pixel-repository" );
        $landingPageFacebookPixelRepo = $this->load( "landing-page-facebook-pixel-repository" );

        $facebookPixels = $facebookPixelRepo->get( [ "*" ], [ "business_id" => $this->business->id ] );
        $facebook_pixel_ids = $facebookPixelRepo->get( [ "id" ], [ "business_id" => $this->business->id ], "raw" );

        if ( $input->exists() && $input->issetField( "add_pixel" ) && $inputValidator->validate(
                $input,
                [
                    "token" => [
                        "equals-hidden" => $this->session->getSession( "csrf-token" ),
                        "required" => true
                    ],
                    "facebook_pixel_id" => [
                        "name" => "Facebook Pixel ID",
                        "required" => true,
                        "max" => 50
                    ],
                    "name" => [
                        "name" => "Pixel Name",
                        "required" => true,
                        "max" => 255
                    ]
                ],

                "facebook_pixel" /* error index */
            ) )
        {
            $facebookPixelRepo->insert([
                "business_id" => $this->business->id,
                "facebook_pixel_id" => $input->get( "facebook_pixel_id" ),
                "name" => $input->get( "name" )
            ]);

            $this->session->addFlashMessage( "Pixel Added: " . $input->get( "name" ) . " - " . $input->get( "facebook_pixel_id" ) );
            $this->session->setFlashMessages();

            $this->view->redirect( "account-manager/business/assets/facebook-pixels" );
        }

        if ( $input->exists() && $input->issetField( "delete_pixel" ) && $inputValidator->validate(
                $input,
                [
                    "token" => [
                        "equals-hidden" => $this->session->getSession( "csrf-token" ),
                        "required" => true
                    ],
                    "facebook_pixel_id" => [
                        "name" => "Facebook Pixel ID",
                        "required" => true,
                        "in_array" => $facebook_pixel_ids,
                    ],
                ],

                "facebook_pixel" /* error index */
            ) )
        {
            $facebookPixelRepo->delete( [ "id" ], [ $input->get( "facebook_pixel_id" ) ] );
            $landingPageFacebookPixelRepo->delete( [ "facebook_pixel_id" ], [ $input->get( "facebook_pixel_id" ) ] );

            $this->session->addFlashMessage( "Pixel Deleted" );
            $this->session->setFlashMessages();

            $this->view->redirect( "account-manager/business/assets/facebook-pixels" );
        }

        $this->view->assign( "facebookPixels", $facebookPixels );
        $this->view->assign( "csrf_token", $this->session->generateCSRFToken() );
        $this->view->assign( "flash_messages", $this->session->getFlashMessages() );
        $this->view->setErrorMessages( $inputValidator->getErrors() );

        $this->view->setTemplate( "account-manager/business/assets/facebook-pixel.tpl" );
        $this->view->render( "App/Views/AccountManager/Assets.php" );
    }

    public function imagesAction()
    {
        $input = $this->load( "input" );
        $inputValidator = $this->load( "input-validator" );
        $imageManager = $this->load( "image-manager" );
        $disciplineRepo = $this->load( "discipline-repository" );
        $imageRepo = $this->load( "image-repository" );
        $config = $this->load( "config" );

        $images = $imageRepo->getAllByBusinessID( $this->business->id );
        $disciplines = $disciplineRepo->getAll();

        if ( $input->exists() && $input->issetField( "upload_image" ) && $inputValidator->validate(

                $input,

                [
                    "token" => [
                        "equals-hidden" => $this->session->getSession( "csrf-token" ),
                        "required" => true
                    ],
                    "upload_image" => [
                        "required" => true
                    ],
                    "description" => [

                    ],
                    "alt" => [

                    ],
                    "discipline_tags" => [
                        "is_array" => true
                    ]

                ],

                "upload_image" /* error index */
            ) )
        {
            $description = null;
            $alt = null;
            $discipline_tags = null;

            if ( $input->get( "discipline_tags" ) != "" ) {
                $discipline_tags = implode( ",", $input->get( "discipline_tags" ) );
            }

            if ( $input->get( "description" ) != "" ) {
                $description = $input->get( "description" );
            }

            if ( $input->get( "alt" ) != "" ) {
                $alt = $input->get( "alt" );
            }

            $image_name = $imageManager->saveImageTo( "image" );
            if ( $image_name ) {
                $imageRepo->create(
                    $image_name,
                    $this->business->id,
                    $description,
                    $alt,
                    $discipline_tags
                );

                $this->view->redirect( "account-manager/business/assets/images" );
            }
        }

        $this->view->assign( "images", $images );
        $this->view->assign( "disciplines", $disciplines );

        $this->view->assign( "csrf_token", $this->session->generateCSRFToken() );
        $this->view->setErrorMessages( $inputValidator->getErrors() );

        $this->view->setTemplate( "account-manager/business/assets/images.tpl" );
        $this->view->render( "App/Views/AccountManager/Assets.php" );
    }

    public function videosAction()
    {
        $input = $this->load( "input" );
        $inputValidator = $this->load( "input-validator" );
        $videoManager = $this->load( "video-manager" );
        $videoRepo = $this->load( "video-repository" );
        $businessRepo = $this->load( "business-repository" );

        $videos = $videoRepo->get( [ "*" ], [ "business_id" => $this->business->id ] );

        ini_set( "post_max_size", "100M" );
        ini_set( "upload_max_filesize", "100M" );

        if ( $input->exists() && $input->issetField( "video" ) && $inputValidator->validate(
                $input,
                [
                    "token" => [
                        "equals-hidden" => $this->session->getSession( "csrf-token" ),
                        "required" => true
                    ],
                    "video" => [
                        "required" => true
                    ],
                    "name" => [
                        "name" => "Video Title",
                        "min" => 1,
                        "max" => 512
                    ],
                    "description" => [
                        "name" => "Description",
                        "min" => 1
                    ],
                    "primary" => [
                    ]
                ],
                "upload_video"
            )
        ) {
            if ( $videoManager->saveVideoTo( "video" ) ) {
                $newVideo = $videoRepo->insert([
                    "business_id" => $this->business->id,
                    "name" => $input->get( "name" ),
                    "description" => $input->get( "description" ),
                    "filename" => $videoManager->getNewVideoFileName(),
                    "type" => $videoManager->getNewVideoType()
                ]);

                if ( $input->get( "primary" ) ) {
                    $businessRepo->update( [ "video_id" => $newVideo->id ], [ "id" => $this->business->id ] );
                }

                $this->session->addFlashMessage( "Video Uploaded" );
                $this->session->setFlashMessages();

                $this->view->redirect( "account-manager/business/assets/videos" );
            }

            // Redirect back if video upload fails
            $this->session->addFlashMessage( "No video was uploaded" );
            $this->session->setFlashMessages();

            $this->view->redirect( "account-manager/business/assets/videos?error=upload_failed" );
        }

        $this->view->assign( "videos", $videos );

        $this->view->assign( "flash_messages", $this->session->getFlashMessages( "flash_messages" ) );
        $this->view->assign( "csrf_token", $this->session->generateCSRFToken() );
        $this->view->setErrorMessages( $inputValidator->getErrors() );

        $this->view->setTemplate( "account-manager/business/assets/videos.tpl" );
        $this->view->render( "App/Views/Home.php" );
    }
}
