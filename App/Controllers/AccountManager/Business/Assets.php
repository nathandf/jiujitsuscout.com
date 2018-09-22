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
                $imageManager->saveImageTo( "image" );
            } else {
                $imageManager->overwriteImage( "image", "public/img/uploads/", "public/img/uploads/" . $this->business->logo_filename );
            }

            $this->businessRepo->updateLogoByID( $this->business->id, $imageManager->getNewImageFileName() );
            $this->view->redirect( "account-manager/business/assets/logo" );
        }

        $this->view->assign( "csrf_token", $this->session->generateCSRFToken() );
        $this->view->setErrorMessages( $inputValidator->getErrors() );

        $this->view->setTemplate( "account-manager/business/assets/logo.tpl" );
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
            $this->view->redirect( "account-manager/business/assets/lead-capture-site" );
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
                    $this->view->redirect( "account-manager/business/assets/lead-capture-site" );
                    break;
                case "false":
                    $faqAnswerRepo->create(
                        $this->business->id,
                        $input->get( "faq_id" ),
                        $input->get( "faq_answer" )
                    );
                    $this->view->redirect( "account-manager/business/assets/lead-capture-site" );
                    break;
                default:
                    break;
            }
        }

        $this->view->assign( "faqs", $faqs );

        $this->view->assign( "csrf_token", $this->session->generateCSRFToken() );
        $this->view->setErrorMessages( $inputValidator->getErrors() );

        $this->view->setTemplate( "account-manager/business/assets/lead-capture-site.tpl" );
        $this->view->render( "App/Views/AccountManager/Assets.php" );
    }

}
