<?php

namespace Controllers;

use \Core\Controller;

class Home extends Controller
{

    public function before()
    {
        $ipinfo = $this->load( "ip-info" );

        // Get geo info of user by ip using the IPInfo API
        $geoIP = $ipinfo->getGeoByIP();

        $this->view->assign( "geo", $geoIP );
    }

    public function indexAction()
    {
        $input = $this->load( "input" );
        $inputValidator = $this->load( "input-validator" );
        $disciplineRepo = $this->load( "discipline-repository" );

        $disciplines = $disciplineRepo->getAll();
        $discipline_names = [];
        foreach ( $disciplines as $discipline ) {
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
            ) )
        {
            if ( in_array( str_replace( "-", " ", $input->get( "discipline" ) ), $discipline_names ) ) {
                $discipline = $disciplineRepo->getByName( str_replace( "-", " ", $input->get( "discipline" ) ) );
            }
        }

        $this->view->assign( "discipline", $discipline );

        $this->view->setTemplate( "home.tpl" );
        $this->view->render( "App/Views/Home.php" );
    }

    public function search()
    {
        $input = $this->load( "input" );
        $inputValidator = $this->load( "input-validator" );
        $searchRepo = $this->load( "search-repository" );
        $resultRepo = $this->load( "result-repository" );
        $businessRepo = $this->load( "business-repository" );
        $geocoder = $this->load( "geocoder" );
        $geometry = $this->load( "geometry" );
        $disciplineRepo = $this->load( "discipline-repository" );
        $reviewRepo = $this->load( "review-repository" );

        // html star builder helper
        require_once( "App/Helpers/fa-return-stars.php" );

        // Set defaults
        $disciplines = $disciplineRepo->getAll();
        $discipline_ids = [];
        $results = [];
        $results_by_distance = [];
        $business_ids = [];
        $search_radius = 15;
        $search_unit = "mi";

        // Create array of discipline ids
        foreach ( $disciplines as $discipline ) {
            $discipline_ids[] = $discipline->id;
        }
        $discipline = null;

        if ( $input->exists( "get" ) && $inputValidator->validate(

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

            // Get latitude and longitude of search query
            $geoInfo = $geocoder->getGeoInfoByAddress( $input->get( "q" ) );

            // Get businesses by discipline id. If discipline id is not specified, get all businesses
            if ( !empty( $input->get( "discid" ) ) ) {
                $businesses = $businessRepo->getAllByDisciplineID( $input->get( "discid" ) );
            } else {
                $businesses = $businessRepo->getAll();
            }

            // If unit is set and in array set new search unit
            if ( $input->issetField( "unit" ) && in_array( $input->get( "unit" ), [ "km", "mi" ] ) ) {
                $search_unit = $input->get( "unit" );
            }

            // If distance is set and less than 50, set new search radius
            if ( $input->issetField( "distance" ) && $input->get( "distance" ) < 50 ) {
                $search_radius = $input->get( "distance" );
            }

            // If geoInfo results are returned, show business listings
            if ( count( $geoInfo->results > 0 ) && !empty( $geoInfo->results ) ) {

                // Set search query lat lng
                $search_latitude = $geoInfo->results[ 0 ]->geometry->location->lat;
                $search_longitude = $geoInfo->results[ 0 ]->geometry->location->lng;

                // Find businesses in range
                foreach ( $businesses as $business ) {

                    // Get distance of businesses from search query in specified unit
                    $distance = $geometry->haversineGreatCircleDistance( $search_latitude, $search_longitude, $business->latitude, $business->longitude, $unit = $search_unit );

                    // If distance of businesses is less than search distanc, populate results
                    if ( $distance <= $search_radius ) {

                        // Set distance and unit from searched location to businesses address
                        $business->distance = $distance;
                        $business->unit = $search_unit;

                        // Get review objects associated with business id
                        $reviews = $reviewRepo->getAllByBusinessID( $business->id );
                        $total_reviews = count( $reviews );

                        // Set default rating
                        $rating = 0;

                        // Font awesome stars html (Will return 5 empty stars)
                        $stars = fa_return_stars( $rating );

                        // If businesses has reviews, process them for listing
                        if ( $total_reviews > 0 ) {
                            $i = 1;
                            foreach ( $reviews as $review ) {
                                $rating = $rating + $review->rating;

                                // Set the last rating for display
                                if ( $i == $total_reviews ) {
                                    $business->reviewer = $review->name;
                                    $business->review = $review->review_body;
                                }
                                $i++;
                            }
                            // Aggregated rating
                            $rating = round( $rating / $total_reviews, 1 );

                            // Replace emply html stars with full ones to reflect the rating
                            $stars = fa_return_stars( $rating );
                        }

                        // Set aggregated rating and stars to business object property
                        $business->rating = $rating;
                        $business->stars = $stars;

                        // Results (unordered)
                        $results[] = $business;

                        // The $business_ids array stores the business ids that were returned
                        // in the results which will be recoded by the result-repository
                        $business_ids[] = $business->id;
                    }
                }
            }

            // Sort results array by distance property of the business objects
            usort( $results, function ( $business_a, $business_b ) {
                return ( $business_a->distance < $business_b->distance ) ? -1 : ( ( $business_a->distance > $business_b->distance ) ? 1 : 0 );
            } );

            // TODO Sort the distance-sorted results by premium, featured, and standard listing types

            $this->view->assign( "results", $results );
            $this->view->assign( "total_results", count( $results ) );
            $this->view->assign( "query", trim( $input->get( "q" ) ) );
            $this->view->assign( "discid", $input->get( "discid" ) );

            $search = $searchRepo->create( $_SERVER[ "REMOTE_ADDR" ], $input->get( "q" ), time() );

            // Save results data and associate with search
            if ( count( $results ) > 0 ) {
                $resultRepo->create( $search->id, implode( ",", $business_ids ) );
            }
        } else {
            // If search input not validated, return to home screen
            $this->view->redirect( "" );
        }

        $this->view->assign( "search_radius", $search_radius );
        $this->view->assign( "unit", $search_unit );

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
                        "in_array" => $businessRepo->getAllBusinessIDs(),
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
            $business = $businessRepo->getByID( $input->get( "business_id" ) );
            // Get phone of business
            $businessPhone = $phoneRepo->getByID( $business->phone_id );
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
        $this->view->setTemplate( "register.tpl" );
        $this->view->render( "App/Views/Home.php" );
    }

    public function studentRegistration()
    {
        echo "Student Registration";
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
