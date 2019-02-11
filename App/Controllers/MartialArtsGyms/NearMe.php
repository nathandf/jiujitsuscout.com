<?php

namespace Controllers\MartialArtsGyms;

use \Core\Controller;

class NearMe extends Controller
{
    public function indexAction()
    {
        // The setParams flag will tell the controller how to handle the parameters.
        $setParams = null;
        if ( isset( $this->params[ "region" ] ) && isset( $this->params[ "locality" ] ) == false ) {
            $setParams = "region";
        } elseif ( isset( $this->params[ "region" ] ) && isset( $this->params[ "locality" ] ) ) {
            $setParams = "region/locality";
        }

        $input = $this->load( "input" );
        $inputValidator = $this->load( "input-validator" );
        $businessRepo = $this->load( "business-repository" );
        $disciplineRepo = $this->load( "discipline-repository" );
        $Config = $this->load( "config" );
        $facebookPixelBuilder = $this->load( "facebook-pixel-builder" );
        $facebookPixelBuilder->addPixelID( $Config::$configs[ "facebook" ][ "jjs_pixel_id" ] );

        // Get all businesses geo info to populate links
        $businesses = $businessRepo->getAll();
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
                    "locality_uri" => preg_replace( "/[ ]+/", "-", strtolower( $business->city ) ),
                    "region" => $business->region,
                    "region_uri" => preg_replace( "/[ ]+/", "-", strtolower( $business->region ) )
                ];

                $businesses_geo_raw[] = $geo_raw;
            }
        }

        ksort( $businesses_geo_info );

        // Build facebook tracking pixel using jiujitsuscout clients pixel id
        $facebookPixelBuilder->addPixelID( $Config::$configs[ "facebook" ][ "jjs_pixel_id" ] );

        switch ( $setParams ) {
            case "region":
                $this->view->setTemplate( "martial-arts-gyms/near-me/by-region.tpl" );
                $this->view->assign( "businesses_geo_info", $businesses_geo_info[ preg_replace( "/[-]+/", " ", $this->params[ "region" ] ) ] );
                $this->view->assign( "region", preg_replace( "/[-]+/", " ", $this->params[ "region" ] ) );
                break;
            case "region/locality":
                // Display the listings based on locality and region
                $accountRepo = $this->load( "account-repository" );
                $reviewRepo = $this->load( "review-repository" );
                $questionnaireDispatcher = $this->load( "questionnaire-dispatcher" );
                $respondentRepo = $this->load( "respondent-repository" );
                $disciplineRepo = $this->load( "discipline-repository" );
                $imageRepo = $this->load( "image-repository" );
                $faqAnswerRepo = $this->load( "faq-answer-repository" );
                $faStars = $this->load( "fa-stars" );

                $businesses = $businessRepo->getAllByLocalityAndRegion(
                    preg_replace( "/[-]+/", " ", $this->params[ "locality" ] ),
                    preg_replace( "/[-]+/", " ", $this->params[ "region" ] )
                );

                // Get and assign all business resources
                foreach ( $businesses as $business ) {
                    // Set disciplines to business object
                    $business->disciplines = [];
                    $business_discipline_ids = [];
                    if ( !is_null( $business->discipline_ids ) ) {
                        $business_discipline_ids = explode( ",", $business->discipline_ids );
                    }

                    foreach ( $business_discipline_ids as $business_discipline_id ) {
                        $discipline = $disciplineRepo->getByID( $business_discipline_id );
                        $business->disciplines[] = $discipline;
                    }

                    // Get review objects associated with business id
                    $business->reviews = $reviewRepo->getAllByBusinessID( $business->id );
                    $total_reviews = count( $business->reviews );
                    $business->total_reviews = $total_reviews;

                    // Set default rating
                    $rating = 0;

                    // Font awesome stars html (Will return 5 empty stars)
                    $stars = $faStars->show( $rating );

                    // If businesses has reviews, process them for listing
                    if ( $total_reviews > 0 ) {
                        $i = 1;
                        foreach ( $business->reviews as $review ) {
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
                        $business->rating = $rating;

                        // Replace emply html stars with full ones to reflect the rating
                        $stars = $faStars->show( $rating );
                    }

                    // Set aggregated rating and stars to business object property
                    $business->rating = $rating;
                    $business->stars = $stars;
                }

                $this->view->assign( "ip", $_SERVER[ "REMOTE_ADDR" ] );
                $this->view->assign( "locality", preg_replace( "/[-]+/", " ", ucwords( $this->params[ "locality" ] ) ) );
                $this->view->assign( "region", preg_replace( "/[-]+/", " ", ucwords( $this->params[ "region" ] ) ) );
                $this->view->assign( "locality_uri", preg_replace( "/[ ]+/", "-", strtolower( $this->params[ "locality" ] ) ) );
                $this->view->assign( "region_uri", preg_replace( "/[ ]+/", "-", strtolower( $this->params[ "region" ] ) ) );
                $this->view->assign( "businesses", $businesses );
                $this->view->setTemplate( "martial-arts-gyms/near-me/gyms-list.tpl" );
                break;
            case null:
                $this->view->redirect( "" );
                break;
        }

        $this->view->assign( "facebook_pixel", $facebookPixelBuilder->build() );
        $this->view->render( "App/Views/MartialArtsGyms/NearMe.php" );
    }
}
