<?php

namespace Controllers;

use \Core\Controller;

class Home extends Controller
{
    public function before()
    {
        $ipinfo = $this->load( "ip-info" );

        $geo_info = $this->session->getCookie( "geo-info" );
        $geo_info_request = $this->session->getCookie( "geo-info-request" );

        if ( is_null( $geo_info ) && is_null( $geo_info_request ) ) {
            // Get geo info of user by ip using the IPInfo API
            $geoIP = $ipinfo->getGeoByIP();

            if ( $geoIP && $geoIP->city != "" && $geoIP->region != "" ) {
                $geo_info = $geoIP->city . ", " . $geoIP->region;
            }

            $this->session->setCookie( "geo-info", $geo_info );
            $this->session->setCookie( "geo-info-request", true );

            $this->view->assign( "geo", $geo_info );
        } else {
            $this->view->assign( "geo", $this->session->getCookie( "geo-info" ) );
        }
    }

    public function indexAction()
    {
        $input = $this->load( "input" );
        $inputValidator = $this->load( "input-validator" );
        $businessRepo = $this->load( "business-repository" );
        $disciplineRepo = $this->load( "discipline-repository" );
        $Config = $this->load( "config" );
        $facebookPixelBuilder = $this->load( "facebook-pixel-builder" );

        $facebookPixelBuilder->addPixelID( $Config::$configs[ "facebook" ][ "jjs_pixel_id" ] );

        // Get all businesses geo info to populate links
        $businesses = $businessRepo->get( [ "*" ] );
        $businesses_geo_info = [];
        $businesses_geo_raw = [];

        foreach ( $businesses as $business ) {
            $geo_raw = preg_replace( "/[ -]+/", "", strtolower( $business->city ) ) . ", " . preg_replace( "/[ -]+/", "", strtolower( $business->region ) );
            if (
                !in_array( $geo_raw, $businesses_geo_raw ) &&
                !is_null( $business->city ) &&
                !is_null( $business->region )
            ) {
                $businesses_geo_info[ strtolower( $business->region ) ][] = [
                    "locality" => $business->city,
                    "locality_url" => preg_replace( "/[ ]+/", "-", strtolower( $business->city ) ),
                    "region" => $business->region,
                    "region_url" => preg_replace( "/[ ]+/", "-", strtolower( $business->region ) )
                ];

                $businesses_geo_raw[] = $geo_raw;
            }
        }

        ksort( $businesses_geo_info );

        $disciplines = $disciplineRepo->get( [ "*" ] );
        $discipline_names = [];

        foreach ( $disciplines as $discipline ) {
            $discipline->url = preg_replace( "/[ ]+/", "-", $discipline->name );
            $discipline_names[] = $discipline->name;
        }

        $discipline = null;

        if ( $input->exists( "get" ) && $input->issetField( "discipline" ) && $inputValidator->validate(
                $input,
                [
                    "discipline" => [
                        "required" => true
                    ]
                ],
                "discipline" /* error index */
            )
        ) {
            if ( in_array( str_replace( "-", " ", $input->get( "discipline" ) ), $discipline_names ) ) {
                $discipline = $disciplineRepo->get( [ "*" ], [ "name" => str_replace( "-", " ", $input->get( "discipline" ) ) ] );
            }
        }

        $this->view->assign( "disciplines", $disciplines );
        $this->view->assign( "businesses_geo_info", $businesses_geo_info );
        $this->view->assign( "discipline", $discipline );
        $this->view->assign( "facebook_pixel", $facebookPixelBuilder->build() );

        $this->view->setTemplate( "home.tpl" );
        $this->view->render( "App/Views/Home.php" );
    }

    public function search()
    {
        $input = $this->load( "input" );
        $inputValidator = $this->load( "input-validator" );
        $searchRepo = $this->load( "search-repository" );
        $resultRepo = $this->load( "result-repository" );
        $disciplineRepo = $this->load( "discipline-repository" );
        $prospectRepo = $this->load( "prospect-repository" );
        $entityFactory = $this->load( "entity-factory" );
        $phoneRepo = $this->load( "phone-repository" );
        $noteRegistrar = $this->load( "note-registrar" );
        $respondentRepo = $this->load( "respondent-repository" );
        $searchResultsDispatcher = $this->load( "search-results-dispatcher" );
        $questionnaireDispatcher = $this->load( "questionnaire-dispatcher" );
        $Config = $this->load( "config" );
        $facebookPixelBuilder = $this->load( "facebook-pixel-builder" );
        $facebookPixelBuilder->addPixelID( $Config::$configs[ "facebook" ][ "jjs_pixel_id" ] );

        // Add Search Event
        $facebookPixelBuilder->addEvent([
            "Search"
        ]);

        // Set defaults
        $disciplines = $disciplineRepo->get( [ "*" ] );
        $discipline_ids = [];

        // Create array of discipline ids
        foreach ( $disciplines as $discipline ) {
            $discipline_ids[] = $discipline->id;
        }
        $discipline = null;

        if ( $input->exists( "get" ) && $input->issetField( "no_results" ) && $inputValidator->validate(

                $input,

                [
                    "token" => [
                        "equals-hidden" => $this->session->getSession( "csrf-token" ),
                        "required" => true
                    ],
                    "name" => [
                        "required" => true
                    ],
                    "number" => [
                        "required" => true,
                        "phone" => true
                    ],
                    "email" => [
                        "required" => true,
                        "email" => true
                    ],
                    "q" => [
                        "required" => true
                    ]
                ],

                "contact_me" /* error index */
            ) )
        {
            $phone = $phoneRepo->create( 0, $input->get( "number" ) );
            $prospect = $entityFactory->build( "Prospect" );
            $prospect->first_name = $input->get( "name" );
            $prospect->last_name = "";
            $prospect->email = $input->get( "email" );
            $prospect->business_id = 0;
            $prospect->source = "No Search Results Page";
            $prospect->phone_id = $phone->id;
            $prospect_id = $prospectRepo->save( $prospect );

            $noteRegistrar->save(
                "Search query: " . $input->get( "q" ),
                0,
                null,
                $prospect_id,
                null,
                null
            );

            $this->view->redirect( "thank-you" );

        } elseif ( $input->exists( "get" ) && $inputValidator->validate(

                $input,

                [
                    "q" => [
                        "required" => true,
                        "max" => 250,
                        "min" => 1
                    ],
                    "discid" => [
                        "in_array" => $discipline_ids
                    ],
                    "distance" => [
                        "numeric" => true
                    ]
                ],

                "search" /* error index */
            ) )
        {
            // Return busiensses within the specified distance from the queried
            // location as well as by discipline
            $results = $searchResultsDispatcher->dispatch(
                $input->get( "q" ),
                $input->get( "discid" ),
                $input->get( "distance" ),
                $input->get( "unit" )
            );

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

            $search = $searchRepo->create( $_SERVER[ "REMOTE_ADDR" ], $input->get( "q" ), time() );

            // Save results data and associate with search
            if ( count( $results ) > 0 ) {
                $resultRepo->create( $search->id, implode( ",", $searchResultsDispatcher->getBusinessIDs() ) );
            }

        } else {
            // If search input not validated, return to home screen
            $this->view->redirect( "" );
        }

        $this->view->assign( "search_radius", $searchResultsDispatcher->getSearchRadius() );
        $this->view->assign( "unit", $searchResultsDispatcher->getSearchUnit() );
        $this->view->assign( "questionnaire", $questionnaire );
        $this->view->assign( "respondent", $respondent );
        $this->view->assign( "results", $results );
        $this->view->assign( "total_results", count( $results ) );
        $this->view->assign( "query", trim( $input->get( "q" ) ) );
        $this->view->assign( "discid", $input->get( "discid" ) );
        $this->view->assign( "ip", $_SERVER[ "REMOTE_ADDR" ] );
        $this->view->assign( "facebook_pixel", $facebookPixelBuilder->build() );

        $this->view->assign( "csrf_token", $this->session->generateCSRFToken() );
        $this->view->setErrorMessages( $inputValidator->getErrors() );

        $this->view->setTemplate( "search.tpl" );
        $this->view->render( "App/Views/Home.php" );
    }

    public function requestAction()
    {
        $input = $this->load( "input" );
        $inputValidator = $this->load( "input-validator" );
        $businessRepo = $this->load( "business-repository" );
        $prospectRegistrar = $this->load( "prospect-registrar" );
        $phoneRepo = $this->load( "phone-repository" );
        $userRepo = $this->load( "user-repository" );
        $userMailer = $this->load( "user-mailer" );
        $disciplineRepo = $this->load( "discipline-repository" );

        // Get all discplines and create an array of discipline ids
        $disciplines = $disciplineRepo->getAll();
        $discipline_ids = [];
        foreach ( $disciplines as $discipline ) {
            $discipline_ids[] = $discipline->id;
        }

        if ( $input->exists() && !$input->issetField( "request" ) ) {
            $this->view->redirect( "" );
        }

        if ( $input->exists() && $input->issetField( "request" ) && $inputValidator->validate(

                $input,

                [
                    "token" => [
                        "equals-hidden" => $this->session->getSession( "csrf-token" ),
                        "required" => true
                    ],
                    "request" => [
                        "required" => true,
                        "in_array" => [ "schedule", "offer" ]
                    ],
                    "business_id" => [
                        "requred" => true,
                        "in_array" => $businessRepo->get( [ "id" ], [], "raw" ),
                    ],
                    "name" => [
                        "required" => true,
                        "min" => 1,
                        "max" => 256
                    ],
                    "email" => [
                        "required" => true,
                        "email" => true
                    ],
                    "number" => [
                        "required" => true,
                        "phone" => true
                    ],
                    "q" => [
                        "required" => true
                    ],
                    "discid" => [
                        "in_array" => $discipline_ids
                    ]
                ],

                "request" /* error index */
            ) )
        {
            // Get business by id
            $business = $businessRepo->get( [ "*" ], [ "id", $input->get( "business_id" ) ] );
            // Get phone of business
            $businessPhone = $phoneRepo->get( [ "*" ], [ "id", $business->phone_id ] );
            // Create a phone resource for prospect
            $phone = $phoneRepo->create( $businessPhone->country_code, $input->get( "number" ) );
            // Build prospect model then save
            $prospect = $prospectRegistrar->build();
            $prospect->business_id = $business->id;
            $prospect->first_name = $input->get( "name" );
            $prospect->email = $input->get( "email" );
            $prospect->phone_id = $phone->id;
            $prospectRegistrar->register( $prospect );
            $user_ids = explode( ",", $business->user_notification_recipient_ids );

            $prospect = $prospectRegistrar->getProspect();

            // Add phone number property to lead
            $prospect->phone_number = $phone->national_number;

            // Get user notification recipients
            foreach ( $user_ids as $id ) {
                $user = $userRepo->getByID( $id );
                $userMailer->sendLeadCaptureNotification(
                    $user->first_name,
                    $user->email,
                    $prospect,
                    "For <b>" . ucfirst( $business->business_name ) . "</b><br> " . ucfirst( $prospect->first_name ) . " filled out the " . $input->get( "request" ) . " request form in the JiuJitsuScout search listings."
                );
            }

            // Send to business lead capture thank-you page
            $this->view->redirect( "martial-arts-gyms/" . $business->site_slug . "/thank-you" );
        }

        $discid_query_string = null;
        if ( $input->issetField( "discid" ) ) {
            $discip_query_string = "&discid=" . $input->get( "discid" );
        }

        // If not validated, send back to search results page
        $this->view->redirect( "search?q=" . $input->get( "q" ) . $discip_query_string );
    }

    public function sitemap()
    {
        $this->view->setTemplate( "sitemap.tpl" );
        $this->view->render( "App/Views/Home.php" );
    }

    public function register()
    {
        $this->view->redirect( "sign-up", 301 );
    }

    public function signUp()
    {
        $Config = $this->load( "config" );
        $facebookPixelBuilder = $this->load( "facebook-pixel-builder" );
        $facebookPixelBuilder->addPixelID( $Config::$configs[ "facebook" ][ "jjs_pixel_id" ] );

        $this->view->assign( "facebook_pixel", $facebookPixelBuilder->build() );

        $this->view->setTemplate( "register.tpl" );
        $this->view->render( "App/Views/Home.php" );
    }

    public function studentRegistration()
    {
        $Config = $this->load( "config" );
        $facebookPixelBuilder = $this->load( "facebook-pixel-builder" );
        $questionnaireDispatcher = $this->load( "questionnaire-dispatcher" );
        $respondentRepo = $this->load( "respondent-repository" );
        $input = $this->load( "input" );
        $inputValidator = $this->load( "input-validator" );

        $facebookPixelBuilder->addPixelID( $Config::$configs[ "facebook" ][ "jjs_pixel_id" ] );

        $facebookPixelBuilder->addEvent([
            "ViewContent"
        ]);

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
            $respondentRepo->create( 2, $respondent_token );
        }

        // Load the respondent object
        $respondent = $respondentRepo->getByToken( $respondent_token );

        if ( $input->exists() && $input->issetField( "register" ) && $inputValidator->validate(
                $input,
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
                    "country_code" => [
                        "required" => true,
                        "numeric" => true
                    ],
                    "phone_number" => [
                        "name" => "Phone",
                        "required" => true,
                        "phone" => true
                    ]
                ],
                "register"
            )
        ) {
            $phoneRepo = $this->load( "phone-repository" );
            $prospectRepo = $this-> load( "prospect-repository" );

            $phone = $phoneRepo->insert([
                "country_code" => $input->get( "country_code" ),
                "national_number" => $input->get( "national_number" )
            ]);

            $prospect = $prospectRepo->insert([
                "business_id" => 0,
                "phone_id" => $phone->id,
                "email" => $input->get( "email" )
            ]);

            $prospect->setNamesFromFullName( $input->get( "name" ) );

            $prospectRepo->update(
                [
                    "first_name" => $prospect->getFirstName(),
                    "last_name" => $prospect->getLastName()
                ],
                [
                    "id" => $prospect->id
                ]
            );

            $respondentRepo->update(
                [ "prospect_id" => $prospect->id ],
                [ "id" => $respondent_id ]
            );

            $prospectAppraiser = $this->load( "prospect-appraiser" );
            $prospectAppraiser->appraise( $prospect );

            $this->view->redirect( "registration-complete" );
        }

        // Dispatch the questionnaire and return the questionnaire object
        $questionnaireDispatcher->dispatch( 2 );
        $questionnaire = $questionnaireDispatcher->getQuestionnaire();

        $this->view->assign( "facebook_pixel", $facebookPixelBuilder->build() );
        $this->view->assign( "csrf_token", $this->session->generateCSRFToken() );
        $this->view->assign( "questionnaire", $questionnaire );
        $this->view->assign( "respondent", $respondent );

        $this->view->setTemplate( "student-registration.tpl" );
        $this->view->render( "App/Views/Home.php" );
    }

    public function registrationComplete()
    {
        $Config = $this->load( "config" );
        $facebookPixelBuilder = $this->load( "facebook-pixel-builder" );
        $questionnaireDispatcher = $this->load( "questionnaire-dispatcher" );
        $respondentRepo = $this->load( "respondent-repository" );

        $facebookPixelBuilder->addPixelID( $Config::$configs[ "facebook" ][ "jjs_pixel_id" ] );

        $facebookPixelBuilder->addEvent([
            "CompleteRegistration",
            "Lead"
        ]);

        $respondent_token = $this->session->getSession( "respondent-token" );
        $respondent = $respondentRepo->get( [ "*" ], [ "token" => $respondent_token ], "single" );

        if ( is_null( $respondent ) ) {
            $this->view->redirect( "student-registration" );
        }

        $this->view->assign( "facebook_pixel", $facebookPixelBuilder->build() );
        $this->view->assign( "csrf_token", $this->session->generateCSRFToken() );
        $this->view->assign( "respondent", $respondent );

        $this->view->setTemplate( "registration-complete.tpl" );
        $this->view->render( "App/Views/Home.php" );
    }

    public function aboutUs()
    {
        $this->view->setTemplate( "about-us.tpl" );
        $this->view->render( "App/Views/Home.php" );
    }

    public function privacyPolicy()
    {
        $this->view->setTemplate( "privacy-policy.tpl" );
        $this->view->render( "App/Views/Home.php" );
    }

    public function termsAndConditions()
    {
        $this->view->setTemplate( "terms-and-conditions.tpl" );
        $this->view->render( "App/Views/Home.php" );
    }

    public function contactMe()
    {
        $input = $this->load( "input" );
        $inputValidator = $this->load( "input-validator" );
        $prospectRepo = $this->load( "prospect-repository" );
        $entityFactory = $this->load( "entity-factory" );
    }

    public function thankYou()
    {
        $Config = $this->load( "config" );
        $facebookPixelBuilder = $this->load( "facebook-pixel-builder" );
        $facebookPixelBuilder->addPixelID( $Config::$configs[ "facebook" ][ "jjs_pixel_id" ] );

        // Track leads
        $facebookPixelBuilder->addEvent([
            "Lead"
        ]);

        $this->view->setTemplate( "thank-you.tpl" );
        $this->view->render( "App/Views/Home.php" );
    }

    // redirects

    public function accountManager()
    {
        $this->view->redirect( "account-manager/", 301 );
    }

    public function jjsAdmin()
    {
        $this->view->redirect( "jjs-admin/", 301 );
    }

    public function partner()
    {
        $this->view->redirect( "partner/", 301 );
    }

    public function martialArtsGyms()
    {
        $this->view->redirect( "martial-arts-gyms/" );
    }
}
