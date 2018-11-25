<?php

namespace Controllers\AccountManager\Business;

use Core\Controller;

class Profile extends Controller
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
        $clickRepo = $this->load( "click-repository" );

        if ( !$this->business->profile_complete ) {
            $imageRepo = $this->load( "image-repository" );
            $faqRepo = $this->load( "faq-repository" );
            $faqAnswerRepo = $this->load( "faq-answer-repository" );
            $videoRepo = $this->load( "video-repository" );

            $faqs_answered = true;
            $business_location_added = true;
            $profile_completion_percentage = 0;

            // Determine whether all faqs were answered
            $faqs = $faqRepo->getAll();

            foreach ( $faqs as $faq ) {
                $faqAnswer = $faqAnswerRepo->getByBusinessIDAndFAQID( $this->business->id, $faq->id );
                if ( is_null( $faqAnswer->id ) ) {
                    $faqAnswer = null;
                    $faqs_answered = false;
                    break;
                }
            }

            if ( $faqs_answered ) {
                $profile_completion_percentage += 17;
            }

            // Check if any location properties are null
            $business_location_properties = [
                $this->business->address_1,
                $this->business->city,
                $this->business->region,
                $this->business->postal_code,
                $this->business->country,
            ];

            foreach ( $business_location_properties as $prop ) {
                if ( is_null( $prop ) ) {
                    $business_location_added = false;
                    break;
                }
            }

            if ( $business_location_added ) {
                $profile_completion_percentage += 17;
            }

            // Load images
            $images = $imageRepo->getAllByBusinessID( $this->business->id );

            // Load video
            $this->business->video = $videoRepo->getByID( $this->business->video_id );

            if ( count( $images ) > 0 ) {
                $profile_completion_percentage += 17;
            }

            if ( !is_null( $this->business->logo_filename ) ) {
                $profile_completion_percentage += 17;
            }

            if ( !is_null( $this->business->message ) ) {
                $profile_completion_percentage += 17;
            }

            if ( !is_null( $this->business->video->id ) ) {
                $profile_completion_percentage += 15;
            }

            if ( $profile_completion_percentage == 100 ) {
                $businessRepo = $this->load( "business-repository" );
                $businessRepo->updateProfileCompleteByID( $this->business->id );
                $this->view->redirect( "account-manager/business/profile/" );
            }

            $this->view->assign( "images", $images );
            $this->view->assign( "faqs_answered", $faqs_answered );
            $this->view->assign( "business_location_added", $business_location_added );
            $this->view->assign( "profile_completion_percentage", $profile_completion_percentage );
        }


        $listing_clicks = $clickRepo->getAllByBusinessIDAndProperty( $this->business->id, "listing" );

        $this->view->assign( "lisiting_clicks", $listing_clicks );

        $this->view->setTemplate( "account-manager/business/profile/home.tpl" );
        $this->view->render( "App/Views/AccountManager/Business.php" );
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
                $imageManager->saveImageTo( "image" );
            } else {
                $imageManager->overwriteImage( "image", "public/img/uploads/", "public/img/uploads/" . $this->business->logo_filename );
            }

            $this->businessRepo->updateLogoByID( $this->business->id, $imageManager->getNewImageFileName() );
            $this->view->redirect( "account-manager/business/profile/logo" );
        }

        $this->view->assign( "csrf_token", $this->session->generateCSRFToken() );
        $this->view->setErrorMessages( $inputValidator->getErrors() );

        $this->view->setTemplate( "account-manager/business/profile/logo.tpl" );
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

                $this->view->redirect( "account-manager/business/profile/images" );
            }
        }

        $this->view->assign( "images", $images );
        $this->view->assign( "disciplines", $disciplines );

        $this->view->assign( "csrf_token", $this->session->generateCSRFToken() );
        $this->view->setErrorMessages( $inputValidator->getErrors() );

        $this->view->setTemplate( "account-manager/business/profile/images.tpl" );
        $this->view->render( "App/Views/AccountManager/Assets.php" );
    }

    public function messageAction()
    {
        $input = $this->load( "input" );
        $inputValidator = $this->load( "input-validator" );

        if ( $input->exists() && $input->issetField( "update_message" ) && $inputValidator->validate(
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
            $this->view->redirect( "account-manager/business/profile/message" );
        }

        $this->view->assign( "csrf_token", $this->session->generateCSRFToken() );
        $this->view->setErrorMessages( $inputValidator->getErrors() );

        $this->view->setTemplate( "account-manager/business/profile/message.tpl" );
        $this->view->render( "App/Views/AccountManager/Assets.php" );
    }

    public function faqsAction()
    {
        $input = $this->load( "input" );
        $inputValidator = $this->load( "input-validator" );
        $faqRepo = $this->load( "faq-repository" );
        $faqAnswerRepo = $this->load( "faq-answer-repository" );

        $faqs = $faqRepo->getAll();

        foreach ( $faqs as $faq ) {
            $faqAnswer = $faqAnswerRepo->getByBusinessIDAndFAQID( $this->business->id, $faq->id );
            if ( is_null( $faqAnswer->id ) ) {
                $faqAnswer = null;
            }
            $faq->faqAnswer = $faqAnswer;
        }

        if ( $input->exists() && $input->issetField( "faq_id" ) && $inputValidator->validate(
            $input,
            [
                "token" => [
                    "equals-hidden" => $this->session->getSession( "csrf-token" ),
                    "required" => true
                ],
                "faq_id" => [
                    "required" => true,
                    "numeric" => true
                ],
                "answered" => [
                    "required" => true
                ],
                "faq_answer" => [

                ]
            ],
            "faq"
        ) )
        {
            switch ( $input->get( "answered" ) ) {
                case "true":
                    $faqAnswerRepo->updateByBusinessIDAndFAQID(
                        $this->business->id,
                        $input->get( "faq_id" ),
                        $input->get( "faq_answer" )
                    );
                    $this->view->redirect( "account-manager/business/profile/faqs" );
                    break;
                case "false":
                    $faqAnswerRepo->create(
                        $this->business->id,
                        $input->get( "faq_id" ),
                        $input->get( "faq_answer" )
                    );
                    $this->view->redirect( "account-manager/business/profile/faqs" );
                    break;
                default:
                    break;
            }
        }

        $this->view->assign( "faqs", $faqs );

        $this->view->assign( "csrf_token", $this->session->generateCSRFToken() );
        $this->view->setErrorMessages( $inputValidator->getErrors() );

        $this->view->setTemplate( "account-manager/business/profile/faqs.tpl" );
        $this->view->render( "App/Views/AccountManager/Assets.php" );
    }

    public function videoAction()
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
                    ]
                ],
                "upload_video"
            )
        ) {
            if ( is_null( $video->id ) ) {
                // If no video has been uploaded before, save the file and create a video reference in the database
                $videoManager->saveVideoTo( "video" );
                $newVideo = $videoRepo->create(
                    $videoManager->getNewVideoFileName(),
                    $videoManager->getNewVideoType(),
                    $this->business->id
                );
            } else {
                // If a video has been uploaded, overwrite the file, save the new reference, and remove the old
                $videoManager->overwriteVideo( "video", "public/videos/" . $video->filename );

                $newVideo = $videoRepo->create(
                    $videoManager->getNewVideoFileName(),
                    $videoManager->getNewVideoType(),
                    $this->business->id
                );

                $videoRepo->removeByID( $this->business->video_id );
            }

            $businessRepo->updateVideoIDByID( $this->business->id, $newVideo->id );

            $this->session->addFlashMessage( "Video Uploaded" );
            $this->session->setFlashMessages();

            $this->view->redirect( "account-manager/business/profile/video" );
        }

        $this->view->assign( "flash_messages", $this->session->getFlashMessages( "flash_messages" ) );
        $this->view->assign( "video", $video );

        $this->view->assign( "csrf_token", $this->session->generateCSRFToken() );
        $this->view->setErrorMessages( $inputValidator->getErrors() );

        $this->view->setTemplate( "account-manager/business/profile/video.tpl" );
        $this->view->render( "App/Views/Home.php" );
    }

}
