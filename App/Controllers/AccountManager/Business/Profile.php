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
        $this->business = $businessRepo->get( [ "*" ], [ "id" => $this->user->getCurrentBusinessID() ], "single" );

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
            $images = $imageRepo->get( [ "*" ], [ "business_id" => $this->business->id ] );

            if ( count( $images ) > 0 ) {
                $profile_completion_percentage += 17;
            }

            if ( !is_null( $this->business->logo_image_id ) ) {
                $profile_completion_percentage += 17;
            }

            if ( !is_null( $this->business->message ) ) {
                $profile_completion_percentage += 17;
            }

            if ( !is_null( $this->business->video_id ) ) {
                $profile_completion_percentage += 15;
            }

            if ( $profile_completion_percentage == 100 ) {
                $businessRepo = $this->load( "business-repository" );
                $businessRepo->update( [ "profile_complete" => 1 ], [ "id" => $this->business->id ] );
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
        $imageRepo = $this->load( "image-repository" );
        $businessRepo = $this->load( "business-repository" );
        $config = $this->load( "config" );

        $images = $imageRepo->get( [ "*" ], [ "business_id" => $this->business->id ] );
        $image_ids = $imageRepo->get( [ "id" ], [ "business_id" => $this->business->id ], "raw" );

        $this->business->logo = null;
        if ( !is_null( $this->business->logo_image_id ) ) {
            $this->business->logo = $imageRepo->get( [ "*" ], [ "id" => $this->business->logo_image_id ], "single" );
        }

        if ( $input->exists() && $inputValidator->validate(
                $input,
                [
                    "token" => [
                        "equals-hidden" => $this->session->getSession( "csrf-token" ),
                        "required" => true
                    ],
                    "image_id" => [
                        "required" => true,
                        "in_array" => $image_ids
                    ]
                ],
                "upload_image" /* error index */
            )
        ) {
            $businessRepo->update( [ "logo_image_id" => $input->get( "image_id" ) ], [ "id" => $this->business->id ] );

            $this->session->addFlashMessage( "Logo Updated" );
            $this->session->setFlashMessages();

            $this->view->redirect( "account-manager/business/profile/logo" );
        }

        $this->view->assign( "csrf_token", $this->session->generateCSRFToken() );
        $this->view->setErrorMessages( $inputValidator->getErrors() );
        $this->view->assign( "flash_messages", $this->session->getFlashMessages() );
        $this->view->assign( "images", $images );

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
        $businessRepo = $this->load( "business-repository" );

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
            $businessRepo->updateSiteMessageByID( $this->business->id, $input->get( "title" ), $input->get( "message" ) );
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
        $videoRepo = $this->load( "video-repository" );
        $businessRepo = $this->load( "business-repository" );

        $video = null;
        if ( !is_null( $this->business->video_id ) ) {
            $video = $videoRepo->get( [ "*" ], [ "id" => $this->business->video_id ], "single" );
        }

        $video_ids = $videoRepo->get( [ "id" ], [ "business_id" => $this->business->id ], "raw" );
        $videos = $videoRepo->get( [ "*" ], [ "business_id" => $this->business->id ] );

        if ( $input->exists() && $input->issetField( "video_id" ) && $inputValidator->validate(
                $input,
                [
                    "token" => [
                        "equals-hidden" => $this->session->getSession( "csrf-token" ),
                        "required" => true
                    ],
                    "video_id" => [
                        "reuired" => true,
                        "in_array" => $video_ids
                    ]
                ],
                "upload_video"
            )
        ) {
            $businessRepo->update( [ "video_id" => $input->get( "video_id" ) ], [ "id" => $this->business->id ] );

            $this->session->addFlashMessage( "Primary Video Updated" );
            $this->session->setFlashMessages();

            $this->view->redirect( "account-manager/business/profile/video" );
        }

        $this->view->assign( "flash_messages", $this->session->getFlashMessages( "flash_messages" ) );
        $this->view->assign( "video", $video );
        $this->view->assign( "videos", $videos );

        $this->view->assign( "csrf_token", $this->session->generateCSRFToken() );
        $this->view->setErrorMessages( $inputValidator->getErrors() );

        $this->view->setTemplate( "account-manager/business/profile/video.tpl" );
        $this->view->render( "App/Views/Home.php" );
    }

}
