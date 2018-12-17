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

        $video = $videoRepo->getByID( $this->business->video_id );

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
                    ]
                ],
                "upload_video"
            )
        ) {
            if ( is_null( $video->id ) ) {
                // If no video has been uploaded before, save the file and create a video reference in the database
                if ( $videoManager->saveVideoTo( "video" ) ) {
                    $newVideo = $videoRepo->create(
                        $videoManager->getNewVideoFileName(),
                        $videoManager->getNewVideoType(),
                        $this->business->id,
                        $input->get( "name" ),
                        $input->get( "description" )
                    );
                } else {
                    // Redirect back to upload page if no video was uploaded
                    $this->session->addFlashMessage( "No video was uploaded" );
                    $this->session->setFlashMessages();
                    $this->view->redirect( "account-manager/business/assets/videos" );
                }
            } else {
                // If a video has been uploaded, overwrite the file, save the new reference, and remove the old
                if ( $videoManager->overwriteVideo( "video", "public/videos/" . $video->filename ) ) {
                    $newVideo = $videoRepo->create(
                        $videoManager->getNewVideoFileName(),
                        $videoManager->getNewVideoType(),
                        $this->business->id,
                        $input->get( "name" ),
                        $input->get( "description" )
                    );
                    $videoRepo->removeByID( $this->business->video_id );
                } else {
                    // Redirect back to upload page if no video was uploaded
                    $this->session->addFlashMessage( "No video was uploaded" );
                    $this->session->setFlashMessages();
                    $this->view->redirect( "account-manager/business/assets/videos" );
                }
            }

            $businessRepo->updateVideoIDByID( $this->business->id, $newVideo->id );

            $this->session->addFlashMessage( "Video Uploaded" );
            $this->session->setFlashMessages();

            $this->view->redirect( "account-manager/business/assets/videos" );
        }

        $this->view->assign( "flash_messages", $this->session->getFlashMessages( "flash_messages" ) );
        $this->view->assign( "video", $video );

        $this->view->assign( "csrf_token", $this->session->generateCSRFToken() );
        $this->view->setErrorMessages( $inputValidator->getErrors() );

        $this->view->setTemplate( "account-manager/business/assets/videos.tpl" );
        $this->view->render( "App/Views/Home.php" );
    }
}
