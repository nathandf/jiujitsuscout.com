<?php

namespace Controllers;

use \Core\Controller;

class Update extends Controller
{

    public function leadDataTransferAction()
    {
        set_time_limit(600);
        // $prospectRegistrar = $this->load( "prospect-registrar" );
        // $prospectRepo = $this->load( "prospect-repository" );
        // $phoneRepo = $this->load( "phone-repository" );
        // $businessRepo = $this->load( "business-repository" );
        //
        // $dm = new \Models\Mappers\DataMapperTEMP($this->container);
        //
        // $leads = $dm->getAll( "leads" );
        // $businesses = $businessRepo->getAll();
        //
        // foreach ( $businesses as $business ) {
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

  public function databaseAction()
  {
    set_time_limit(300);


    /**
     * Creating account_user(s) from users from user table
     */
    // $userRepo = $this->load( "user-repository" );
    // $accountUserRepo = $this->load( "account-user-repository" );
    // $users = $userRepo->getAll();
    // foreach ( $users as $user ) {
    //   $accountUserRepo->register( $user->account_id, $user->id );
    // }
    /**
     * Creating phone(s) from users from user, prospect, member tables
     */
  //   $userRepo = $this->load( "user-repository" );
  //   $prospectRepo = $this->load( "prospect-repository" );
  //   $memberRepo = $this->load( "member-repository" );
  //   $phoneRepo = $this->load( "phone-repository" );
  //   $users = $userRepo->getAll();
  //   $prospects = $prospectRepo->getAll();
  //   $members = $memberRepo->getAll();
  //   foreach ( $users as $user ) {
  //     $phone = $phoneRepo->create( 1, $user->phone_number );
  //     if ( !is_null( $user->phone_number ) || $user->phone_number != "" && is_numeric( $user->phone_number ) ) {
  //       $userRepo->updatePhoneIDByID( $phone->id, $user->id );
  //     }
  //   }
  //   foreach ( $members as $member ) {
  //     $phone = $phoneRepo->create( 1, $member->phone_number );
  //     if ( !is_null( $member->phone_number ) || $member->phone_number != "" && is_numeric( $member->phone_number ) ) {
  //       $memberRepo->updatePhoneIDByID( $phone->id, $member->id );
  //     }
  //   }
  //   foreach ( $prospects as $prospect ) {
  //     $phone = $phoneRepo->create( 1, $prospect->phone_number );
  //     if ( !is_null( $prospect->phone_number ) || $prospect->phone_number != "" && is_numeric( $prospect->phone_number ) ) {
  //       $prospectRepo->updatePhoneIDByID( $phone->id, $prospect->id );
  //     }
  //   }
  }
}
