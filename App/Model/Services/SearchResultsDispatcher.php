<?php

namespace Model\Services;

use Model\Services\AccountRepository,
    Model\Services\BusinessRepository,
    Model\Services\ReviewRepository,
    Contracts\GeocoderInterface,
    Helpers\Geometry;


class SearchResultsDispatcher
{
    public $accountRepo;
    public $businessRepo;
    public $reviewRepo;
    public $geocoder;
    public $geometry;
    public $results = [];
    public $results_by_distance = [];
    public $search_radius = 15;
    public $search_unit = "mi";
    public $business_ids = [];


    public function __construct(
        AccountRepository $accountRepo,
        BusinessRepository $businessRepo,
        ReviewRepository $reviewRepo,
        GeocoderInterface $geocoder,
        Geometry $geometry
    )
    {
        $this->accountRepo = $accountRepo;
        $this->businessRepo = $businessRepo;
        $this->reviewRepo = $reviewRepo;
        $this->geocoder = $geocoder;
        $this->geometry = $geometry;
    }

    public function dispatch( $query, $discipline_id = null, $radius = null, $unit = null )
    {
        // Get latitude and longitude of search query
        $geoInfo = $this->geocoder->getGeoInfoByAddress( $query );

        // Get businesses by discipline id. If discipline id is not specified, get all businesses
        if ( !is_null( $discipline_id ) && $discipline_id != "" ) {
            $businesses = $this->businessRepo->getAllByDisciplineID( $discipline_id );
        } else {
            $businesses = $this->businessRepo->getAll();
        }

        // Load the account tho which each businesses is associated
        foreach ( $businesses as $business ) {
            $business->account = $this->accountRepo->getByID( $business->account_id );
        }

        // If unit is set and in array set new search unit
        if ( !is_null( $unit ) && $unit != "" && in_array( $unit, [ "km", "mi" ] ) ) {
            $this->search_unit = $unit;
        }

        // If distance is set and less than 50, set new search radius
        if ( !is_null( $radius ) && $radius != "" && $radius < 50 ) {
            $this->search_radius = $radius;
        }

        // If geoInfo results are returned, show business listings
        if ( count( $geoInfo->results > 0 ) && !empty( $geoInfo->results ) ) {

            // Set search query lat lng
            $search_latitude = $geoInfo->results[ 0 ]->geometry->location->lat;
            $search_longitude = $geoInfo->results[ 0 ]->geometry->location->lng;

            // Find businesses in range
            foreach ( $businesses as $business ) {

                // html star builder helper
                require_once( "App/Helpers/fa-return-stars.php" );

                // Get distance of businesses from search query in specified unit
                $distance = $this->geometry->haversineGreatCircleDistance(
                    $search_latitude,
                    $search_longitude,
                    $business->latitude,
                    $business->longitude,
                    $unit = $this->search_unit );

                // If distance of businesses is less than search distance, populate results
                if ( $distance <= $this->search_radius ) {

                    // Set distance and unit from searched location to businesses address
                    $business->distance = $distance;
                    $business->unit = $this->search_unit;

                    // Get review objects associated with business id
                    $reviews = $this->reviewRepo->getAllByBusinessID( $business->id );
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
                    $this->results[] = $business;

                    // The $business_ids array stores the business ids that were returned
                    // in the results which will be recoded by the result-repository
                    $this->business_ids[] = $business->id;
                }
            }
        }

        // Sort results array by distance property of the business objects
        usort( $this->results, function ( $business_a, $business_b ) {
            return ( $business_a->distance < $business_b->distance ) ? -1 : ( ( $business_a->distance > $business_b->distance ) ? 1 : 0 );
        } );

        return $this->results;
    }

    public function getBusinessIDs()
    {
        return $this->business_ids;
    }

    public function getSearchRadius()
    {
        return $this->search_radius;
    }

    public function getSearchUnit()
    {
        return $this->search_unit;
    }

}
