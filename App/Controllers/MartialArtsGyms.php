<?php

namespace Controllers;

use \Core\Controller;

class MartialArtsGyms extends Controller
{
    public $business;

    protected function before()
    {
        $this->requireParam( "siteslug" );

        $businessRepo = $this->load( "business-repository" );
        $phoneRepo = $this->load( "phone-repository" );
        $facebookPixelBuilder = $this->load( "facebook-pixel-builder" );
        $Config = $this->load( "config" );

        // Get business by the unique URL slug
        $this->business = $businessRepo->getBySiteSlug( $this->params[ "siteslug" ] );

        // Render 404 if no business is returned
        if ( is_null( $this->business->id ) || $this->business->id == "" ) {
            $this->view->render404();
        }

        // Get phone associated with this business
        $phone = $phoneRepo->getByID( $this->business->phone_id );
        $this->business->phone = $phone;

        // Build facebook tracking pixel using jiujitsuscout clients pixel id
        $facebookPixelBuilder->setPixelID( $Config::$configs[ "facebook" ][ "jjs_pixel_id" ] );

        // Replace the facebook pixel if user specifies a pixel id of their own
        if ( !is_null( $this->business->facebook_pixel_id ) && $this->business->facebook_pixel_id != "" ) {
            $facebookPixelBuilder->setPixelID( $this->business->facebook_pixel_id );
        }

        $this->view->assign( "business", $this->business );
        $this->view->assign( "facebook_pixel", $facebookPixelBuilder->build() );
        $this->view->assign( "google_api_key", $Config::$configs[ "google" ][ "api_key" ] );
    }

    public function index()
    {
        if ( !$this->issetParam( "siteslug" ) ) {
            $this->view->redirect( "" );
        } else {

            // Load input and input validation helpers and services
            $Config = $this->load( "config" );
            $accountRepo = $this->load( "account-repository" );
            $businessRepo = $this->load( "business-repository" );
            $reviewRepo = $this->load( "review-repository" );
            $input = $this->load( "input" );
            $inputValidator = $this->load( "input-validator" );
            $prospectRepo = $this->load( "prospect-repository" );
            $prospectRegistrar = $this->load( "prospect-registrar" );
            $userRepo = $this->load( "user-repository" );
            $userMailer = $this->load( "user-mailer" );
            $phoneRepo = $this->load( "phone-repository" );
            $facebookPixelBuilder = $this->load( "facebook-pixel-builder" );
            $questionnaireDispatcher = $this->load( "questionnaire-dispatcher" );
            $respondentRepo = $this->load( "respondent-repository" );
            $disciplineRepo = $this->load( "discipline-repository" );
            $imageRepo = $this->load( "image-repository" );
            $prospectAppraiser = $this->load( "prospect-appraiser" );
            $prospectPurchaseRepo = $this->load( "prospect-purchase-repository" );
            $faqRepo = $this->load( "faq-repository" );
            $faqAnswerRepo = $this->load( "faq-answer-repository" );
            $faStars = $this->load( "fa-stars" );

            // Dispatch questionnaire

            // Check session for a respondent token. If one doesnt exit, create a
            // new respondent and dispatch the questionnaire. If a respondent does
            // exist, load the respodent and pass through the last question id to
            // start the questionnaire where that respondent left off.
            $respondent_token = $this->session->getSession( "respondent-token" );

            if ( is_null( $respondent_token ) ) {
                // Generate a new token
                $respondent_token = $this->session->generateToken();

                // Set the session with the new respondent token
                $this->session->setSession( "respondent-token", $respondent_token );

                // Create a respondent with this questionnaire_id and respondent token
                $respondentRepo->create( 1, $respondent_token );
            }

            // Load the respondent object
            $respondent = $respondentRepo->getByToken( $respondent_token );

            // Dispatch the questionnaire and return the questionnaire object
            $questionnaireDispatcher->dispatch( 1 );
            $questionnaire = $questionnaireDispatcher->getQuestionnaire();

            // Get business by the unique URL slug
            $this->business = $businessRepo->getBySiteSlug( $this->params[ "siteslug" ] );

            // Get phone associated with this business
            $phone = $phoneRepo->getByID( $this->business->phone_id );
            $this->business->phone = $phone;

            // Load the account this business is associated with
            $this->account = $accountRepo->getByID( $this->business->account_id );

            // Get images for this business
            $images = $imageRepo->getAllByBusinessID( $this->business->id );

            // Render 404 if no business is returned
            if ( is_null( $this->business->id ) || $this->business->id == "" ) {
                $this->view->render404();
            }

            // Load all disciplines and attach to business object
            $this->business->disciplines = [];
            $business_discipline_ids = explode( ",", $this->business->discipline_ids );

            foreach ( $business_discipline_ids as $discipline_id ) {
                if ( $discipline_id != "" ) {
                    $discipline = $disciplineRepo->getByID( $discipline_id );
                    $this->business->disciplines[] = $discipline;
                }
            }

            // Create an array of the available programs on the business object
            $this->business->programs = explode( ",", $this->business->programs );

            if ( $this->business->programs[ 0 ] == "" ) {
                $this->business->programs = [];
            }

            // Build facebook tracking pixel using jiujitsuscout clients pixel id
            $facebookPixelBuilder->setPixelID( $Config::$configs[ "facebook" ][ "jjs_pixel_id" ] );

            // Get reviews from business id
            $this->business->reviews = $reviewRepo->getAllByBusinessID( $this->business->id );

            // Calculating number and total of ratings
            $sum_rating = 0;
            $total_ratings = 0;
            $business_rating = 0;
            foreach ( $this->business->reviews as $review ) {
                $sum_rating = $sum_rating + $review->rating;
                $review->html_stars = $faStars->show( $review->rating );
                $total_ratings++;
            }

            if ( $total_ratings > 0 ) {
                $business_rating = round( $sum_rating / $total_ratings, 1 );
            }

            // return html stars
            $html_stars = $faStars->show( $business_rating );

            // Get all FAQs
            $faqs = $faqRepo->getAll();

            // Get all FAQs answered by this business
            $faqAnswers = [];
            foreach ( $faqs as $faq ) {
                $faqAnswer = $faqAnswerRepo->getByBusinessIDAndFAQID( $this->business->id, $faq->id );
                if ( !is_null( $faqAnswer->id ) ) {
                    $faqAnswer->faq = $faq;
                    $faqAnswers[] = $faqAnswer;
                }
            }

            if ( $input->exists() && $input->issetField( "capture" ) && $inputValidator->validate(
                $input,
                [
                    "token" => [
                        "equals-hidden" => $this->session->getSession( "csrf-token" ),
                        "required" => true
                    ],
                    "name" => [
                        "name" => "Name",
                        "required" => true,
                        "min" => 1
                    ],
                    "email" => [
                        "name" => "Email",
                        "required" => true,
                        "email" => true
                    ],
                    "phone" => [
                        "name" => "Phone Number",
                        "required" => true,
                        "phone" => true
                    ],
                    "message" => [
                        "name" => "Message",
                    ]
                ],
                "capture"
                ) )
            {
                $message = null;
                if ( $input->get( "message" ) != "" ) {
                    $message = "Message from lead: " . $input->get( "message" );
                }
                $phone = $phoneRepo->create( $this->business->phone->country_code, preg_replace( "/[^0-9]/", "", $input->get( "phone" ) ) );

                $prospectRegistrar->add([
                    "first_name" => $input->get( "name" ),
                    "email" => strtolower( $input->get( "email" ) ),
                    "phone_id" => $phone->id,
                    "business_id" => $this->business->id,
                    "source" => "JiuJitsuScout Profile"
                ]);

                $prospect = $prospectRegistrar->getProspect();

                // Load the respondent object
                $respondent = $respondentRepo->getByToken( $this->session->getSession( "respondent-token" ) );

                $respondentRepo->updateProspectIDByID( $respondent->id, $prospect->id );

                $prospect_price = $prospectAppraiser->appraise( $prospect );

                if ( $this->account->credit >= $prospect_price ) {

                    if ( $this->account->auto_purchase == true ) {

                        // Remove credit from the account for the amount of the prospect's appraisal
                        $accountRepo->debitAccountByID( $this->account->id, $prospect_price );

                        // Record a prospect purchase
                        $prospectPurchaseRepo->create( $this->business->id, $prospect->id );

                        // Get the users that require email lead notifications
                        $users = [];
                        $user_ids = explode( ",", $this->business->user_notification_recipient_ids );

                        // Populate users array with users data
                        foreach ( $user_ids as $user_id ) {
                            $users[] = $userRepo->getByID( $user_id );
                        }

                        // Send lead caputre notification to all users in user_notification_recipient_ids array
                        foreach ( $users as $user ) {
                            $userMailer->sendLeadCaptureNotification(
                                $user->first_name,
                                $user->email,
                                [
                                    "name" => $prospect->first_name,
                                    "email" => $prospect->email,
                                    "number" => "+" . $phone->country_code  . " " . $phone->national_number,
                                    "source" => "JiuJitsuScout Profile",
                                    "id" => $prospect->id,
                                    "additional_info" => $message
                                ]
                            );
                        }

                        $this->view->redirect( "martial-arts-gyms/" . $this->params[ "siteslug" ] . "/registration-complete" );
                    } else {
                        // Mark this lead as requiring a purchase
                        $prospectRepo->updateRequiresPurchaseByID( $prospect->id, 1 );

                        // Get the users that require email lead notifications
                        $users = [];
                        $user_ids = explode( ",", $this->business->user_notification_recipient_ids );

                        // Populate users array with users data
                        foreach ( $user_ids as $user_id ) {
                            $users[] = $userRepo->getByID( $user_id );
                        }

                        // Send the email to each user
                        foreach ( $users as $user ) {
                            $userMailer->sendLeadCapturePurchaseRequiredNotification(
                                $user->first_name,
                                $user->email,
                                [
                                    "id" => $prospect->id,
                                    "name" => $prospect->first_name,
                                    "source" => "JiuJitsuScout Profile",
                                    "additional_info" => $message
                                ]
                            );
                        }

                        $this->view->redirect( "martial-arts-gyms/" . $this->params[ "siteslug" ] . "/registration-complete" );
                    }
                } else {
                    // Mark this lead as requiring a purchase
                    $prospectRepo->updateRequiresPurchaseByID( $prospect->id, 1 );

                    // Send an insufficient funs notice to the primary user
                    $user = $userRepo->getByID( $this->account->primary_user_id );
                    $userMailer->sendInsufficientFundsNotification( $user->first_name, $user->email );

                    // Redirect to registration complete page
                    $this->view->redirect( "martial-arts-gyms/" . $this->params[ "siteslug" ] . "/registration-complete" );
                }
            }

            // Set variables to populate inputs after form submission failure and assign to view
            $inputs = [];

            $this->view->assign( "inputs", $inputs );
            $this->view->assign( "csrf_token", $this->session->generateCSRFToken() );

            $this->view->setErrorMessages( $inputValidator->getErrors() );

            // Assign data the view
            $this->view->assign( "questionnaire", $questionnaire );
            $this->view->assign( "respondent", $respondent );
            $this->view->assign( "google_api_key", $Config::$configs[ "google" ][ "api_key" ] );
            $this->view->assign( "facebook_pixel", $facebookPixelBuilder->build() );
            $this->view->assign( "business", $this->business );
            $this->view->assign( "html_stars", $html_stars );
            $this->view->assign( "total_ratings", $total_ratings );
            $this->view->assign( "business_rating", $business_rating );
            $this->view->assign( "images", $images );
            $this->view->assign( "faqAnswers", $faqAnswers );
            $this->view->setTemplate( "martial-arts-gyms/home.tpl" );
        }

        $this->view->render( "App/Views/MartialArtsGyms.php" );
    }

    public function registrationComplete()
    {
        $this->requireParam( "siteslug" );

        $businessRepo = $this->load( "business-repository" );
        $phoneRepo = $this->load( "phone-repository" );
        $facebookPixelBuilder = $this->load( "facebook-pixel-builder" );
        $faqRepo = $this->load( "faq-repository" );
        $faqAnswerRepo = $this->load( "faq-answer-repository" );
        $Config = $this->load( "config" );

        // Get business by the unique URL slug
        $this->business = $businessRepo->getBySiteSlug( $this->params[ "siteslug" ] );

        // Render 404 if no business is returned
        if ( is_null( $this->business->id ) || $this->business->id == "" ) {
            $this->view->render404();
        }

        // Get phone associated with this business
        $phone = $phoneRepo->getByID( $this->business->phone_id );
        $this->business->phone = $phone;

        // Build facebook tracking pixel using jiujitsuscout clients pixel id
        $facebookPixelBuilder->setPixelID( $Config::$configs[ "facebook" ][ "jjs_pixel_id" ] );

        // Add Lead event
        $facebookPixelBuilder->addEvent([
            "Lead"
        ]);

        // Get all FAQs
        $faqs = $faqRepo->getAll();

        // Get all FAQs answered by this business
        $faqAnswers = [];
        foreach ( $faqs as $faq ) {
            $faqAnswer = $faqAnswerRepo->getByBusinessIDAndFAQID( $this->business->id, $faq->id );
            if ( !is_null( $faqAnswer->id ) ) {
                $faqAnswer->faq = $faq;
                $faqAnswers[] = $faqAnswer;
            }
        }

        $this->view->assign( "faqAnswers", $faqAnswers );
        $this->view->assign( "business", $this->business );
        $this->view->assign( "facebook_pixel", $facebookPixelBuilder->build() );

        $this->view->setTemplate( "martial-arts-gyms/registration-complete.tpl" );
        $this->view->render( "App/Views/MartialArtsGyms.php" );
    }

    public function homeAction()
    {
        $this->view->redirect( "martial-arts-gyms/" . $this->business->site_slug . "/" );
    }

    public function thankYouAction()
    {
        $Config = $this->load( "config" );

        $prospectRegistrar = $this->load( "prospect-registrar" );
        $userRepo = $this->load( "user-repository" );
        $userMailer = $this->load( "user-mailer" );
        $reviewRepo = $this->load( "review-repository" );
        $phoneRepo = $this->load( "phone-repository" );
        $facebookPixelBuilder = $this->load( "facebook-pixel-builder" );

        // Build facebook tracking pixel using jiujitsuscout clients pixel id
        $facebookPixelBuilder->setPixelID( $Config::$configs[ "facebook" ][ "jjs_pixel_id" ] );

        // Replace the facebook pixel if user specifies a pixel id of their own
        if ( !is_null( $this->business->facebook_pixel_id ) && $this->business->facebook_pixel_id != "" ) {
            $facebookPixelBuilder->setPixelID( $this->business->facebook_pixel_id );
        }

        // Add Lead event
        $facebookPixelBuilder->addEvent([
            "Lead"
        ]);

        // Get phone resource and set phone_number property for business object
        $phone = $phoneRepo->getByID( $this->business->phone_id );
        $this->business->phone_number = $phone->national_number;

        $this->view->assign( "facebook_pixel", $facebookPixelBuilder->build() );
        $this->view->assign( "business", $this->business );
        $this->view->setTemplate( "martial-arts-gyms/thank-you.tpl" );
        $this->view->render( "App/Views/MartialArtsGyms.php" );
    }

    public function promoAction()
    {
        $Config = $this->load( "config" );
        $businessRepo = $this->load( "business-repository" );
        $reviewRepo = $this->load( "review-repository" );
        $input = $this->load( "input" );
        $inputValidator = $this->load( "input-validator" );
        $prospectRegistrar = $this->load( "prospect-registrar" );
        $userRepo = $this->load( "user-repository" );
        $userMailer = $this->load( "user-mailer" );
        $phoneRepo = $this->load( "phone-repository" );
        $facebookPixelBuilder = $this->load( "facebook-pixel-builder" );

        $this->view->assign( "business", $this->business );
        $this->requireParam( "slug" );

        $landingPageRepo = $this->load( "landing-page-repository" );
        $landingPage = $landingPageRepo->getBySlugAndBusinessID( $this->params[ "slug" ], $this->business->id );

        // Render 404 page if there is no landing page with this slug and business_id
        if ( is_null( $landingPage->id ) || $landingPage->id == "" ) {
            $this->view->render404();
        }
        // Build facebook tracking pixel using jiujitsuscout clients pixel id
        $facebookPixelBuilder->setPixelID( $Config::$configs[ "facebook" ][ "jjs_pixel_id" ] );

        // Replace the facebook pixel if user specifies a pixel id of their own
        if ( !is_null( $landingPage->facebook_pixel_id ) && $landingPage->facebook_pixel_id != "" ) {
            $facebookPixelBuilder->setPixelID( $landingPage->facebook_pixel_id);
        }

        if ( $input->exists() && $input->issetField( "landing_page" ) && $inputValidator->validate( $input,
                [
                    "token" => [
                        "equals-hidden" => $this->session->getSession( "csrf-token" ),
                        "required" => true
                    ],
                    "name" => [
                        "name" => "Name",
                        "required" => true
                    ],
                    "email" => [
                        "name" => "Email",
                        "required" => true,
                        "email" => true
                    ],
                    "number" => [
                        "name" => "Phone Number",
                        "required" => true,
                        "min" => 6,
                        "max" => 50,
                        "phone" => true
                    ]
                ],

                "landing_page" // error index
            ) )
        {
            $prospect = $prospectRegistrar->build();
            $prospect->first_name = $input->get( "name" );
            $prospect->last_name = "";
            $prospect->email = strtolower( $input->get( "email" ) );
            $phone = $phoneRepo->create( $this->business->phone->country_code, preg_replace( "/[^0-9]/", "", $input->get( "number" ) ) );
            $prospect->phone_id = $phone->id;
            $prospect->business_id = $this->business->id;
            $prospect->source = $landingPage->name;
            $prospectRegistrar->register( $prospect );

            // Get the users that require email lead notifications
            $users = [];
            $user_ids = explode( ",", $this->business->user_notification_recipient_ids );

            // Populate users array with users data
            foreach ( $user_ids as $user_id ) {
                $users[] = $userRepo->getByID( $user_id );
            }

            // Send the email to each user
            foreach ( $users as $user ) {
                $userMailer->sendLeadCaptureNotification(
                    $user->first_name,
                    $user->email,
                    [
                        "name" => $prospect->first_name,
                        "email" => $prospect->email,
                        "number" => "+" . $phone->country_code  . " " . $phone->national_number,
                        "source" => $prospect->source,
                        "id" => $prospect->id,
                        "additional_info" => "N/a"
                    ]
                );
            }

            $this->view->redirect( "martial-arts-gyms/{$this->params[ "siteslug" ]}/thank-you" );
        }

        $this->view->assign( "page", $landingPage );

        // Set variables to populate inputs after form submission failure and assign to view
        $inputs = [];

        // sidebar_promo
        if ( $input->issetField( "sidebar_promo" ) ) {
            $inputs[ "landing_page" ][ "name" ] = $input->get( "name" );
            $inputs[ "landing_page" ][ "email" ] = $input->get( "email" );
            $inputs[ "landing_page" ][ "number" ] = $input->get( "number" );
        }

        // Input values submitted from form
        $this->view->assign( "inputs", $inputs );

        $this->view->assign( "csrf_token", $this->session->generateCSRFToken() );
        $this->view->setErrorMessages( $inputValidator->getErrors() );

        $this->view->setTemplate( "martial-arts-gyms/landing-page-templates/" . $landingPage->template_file );
        $this->view->render( "App/Views/MartialArtsGyms.php" );
    }

    public function leaveReviewAction()
    {
        // Load input and input validation helpers and services
        $Config = $this->load( "config" );
        $businessRepo = $this->load( "business-repository" );
        $reviewRepo = $this->load( "review-repository" );
        $input = $this->load( "input" );
        $inputValidator = $this->load( "input-validator" );
        $prospectRegistrar = $this->load( "prospect-registrar" );
        $userRepo = $this->load( "user-repository" );
        $userMailer = $this->load( "user-mailer" );
        $phoneRepo = $this->load( "phone-repository" );
        $faStars = $this->load( "fa-stars" );

        // Get reviews from business id
        $reviews = $reviewRepo->getAllByBusinessID( $this->business->id );
        // Calculating number and total of ratings
        $sum_rating = 0;
        $total_ratings = 0;
        $business_rating = 0;
        foreach ( $reviews as $review ) {
            $sum_rating = $sum_rating + $review->rating;
            $total_ratings++;
        }

        if ( $total_ratings > 0 ) {
            $business_rating = round( $sum_rating / $total_ratings, 1 );
        }

        // return html stars
        $html_stars = $faStars->show( $business_rating );

        if ( $input->exists() && $input->issetField( "rate_review" ) && $inputValidator->validate( $input,
                [
                    "token" => [
                        "equals-hidden" => $this->session->getSession( "csrf-token" ),
                        "required" => true
                    ],
                    "name" => [
                        "name" => "Name",
                        "required" => true,
                        "min" => 1,
                        "max" => 50
                    ],
                    "email" => [
                        "name" => "Email",
                        "required" => true,
                        "email" => true
                    ],
                    "rating" => [
                        "name" => "Rating",
                        "required" => true
                    ],
                    "review" => [
                        "name" => "Review",
                        "required" => true
                    ]
                ], "review" // error index
            ) )
        {
            $reviewRepo->create( $this->business->id, $input->get( "name" ), $input->get( "email" ), $input->get( "review" ), $input->get( "rating" ), time() );

            // Get the users that require email lead notifications
            $users = [];
            $user_ids = explode( ",", $this->business->user_notification_recipient_ids );

            // Populate users array with users data
            foreach ( $user_ids as $user_id ) {
                $users[] = $userRepo->getByID( $user_id );
            }

            // Send the email to each user
            foreach ( $users as $user ) {
                $userMailer->sendReviewNotification(
                    $user->first_name,
                    $user->email,
                    [
                        "name" => $input->get( "name" ),
                        "email" => $input->get( "email" ),
                        "rating" => $input->get( "rating" ) . " out of 5",
                        "review" => $input->get( "review" )
                    ]
                );
            }

            $this->view->redirect( "martial-arts-gyms/" . $this->business->site_slug . "/reviews" );
        }

        // Set variables to populate inputs after form submission failure and assign to view
        $inputs = [];
        // info request
        if ( $input->issetField( "review" ) ) {
            $inputs[ "review" ][ "name" ] = $input->get( "name" );
            $inputs[ "review" ][ "email" ] = $input->get( "email" );
            $inputs[ "review" ][ "number" ] = $input->get( "number" );
        }

        $this->view->assign( "inputs", $inputs );

        $csrf_token = $this->session->generateCSRFToken();
        $this->view->assign( "csrf_token", $csrf_token );

        $this->view->setErrorMessages( $inputValidator->getErrors() );

        // Assign data the view
        $this->view->assign( "reviews", $reviews );
        $this->view->assign( "business", $this->business );
        $this->view->assign( "html_stars", $html_stars );
        $this->view->assign( "total_ratings", $total_ratings );
        $this->view->assign( "business_rating", $business_rating );

        $this->view->setTemplate( "martial-arts-gyms/leave-review.tpl" );
        $this->view->render( "App/Views/MartialArtsGyms.php" );
    }

}
