<?php

namespace Controllers;

use \Core\Controller;

class Update extends Controller
{

    public function partnerDataTransferAction()
    {
        set_time_limit(600);
        // $prospectRegistrar = $this->load( "prospect-registrar" );
        // $prospectRepo = $this->load( "prospect-repository" );
        // $phoneRepo = $this->load( "phone-repository" );
        // $businessRepo = $this->load( "business-repository" );
        // $reviewRepo = $this->load( "review-repository" );
        //
        // $dm = new \Models\Mappers\DataMapperTEMP($this->container);
        //
        // $ratings_reviews = $dm->getAll( "ratings_reviews" );
        // $leads = $dm->getAll( "leads" );
        // $tracking_codes = $dm->getAll( "partner_tracking_codes" );
        // $businesses = $businessRepo->getAll();
        //
        // foreach ( $businesses as $business ) {
        //     foreach ( $tracking_codes as $tc ) {
        //         if ( $tc[ "owner" ] == $business->business_name ) {
        //             $businessRepo->updateFacebookPixelIDBYID( trim( $tc[ "tracking_code_id" ] ), $business->id );
        //         }
        //     }
        //     foreach ( $ratings_reviews as $rr ) {
        //         if ( $rr[ "gym_name" ] == $business->business_name ) {
        //             $reviewRepo->create(
        //                 $business->id,
        //                 $rr[ "name" ],
        //                 $rr[ "email" ],
        //                 $rr[ "review" ],
        //                 $rr[ "rating" ],
        //                 strtotime( $rr[ "timestamp" ] )
        //             );
        //         }
        //     }
        //     foreach ( $leads as $lead ) {
        //         if ( $lead[ "gym_name" ] == $business->business_name ) {
        //             $prospect = $prospectRegistrar->build();
        //             $prospect->business_id = $business->id;
        //             $prospect->first_name = $lead[ "name" ];
        //             $prospect->last_name = "";
        //             $prospect->email = $lead[ "email" ];
        //             $prospect->source = $lead[ "source" ];
        //             $phone = $phoneRepo->create( 1, preg_replace( "/[^0-9,.]/", "", $lead[ "phone_number" ] ) );
        //             $prospect->phone_id = $phone->id;
        //             $prospectRegistrar->register( $prospect );
        //         }
        //     }
        // }
    }
}
