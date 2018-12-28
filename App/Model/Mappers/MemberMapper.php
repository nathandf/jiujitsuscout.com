<?php

namespace Model\Mappers;

use Model\Member;

class MemberMapper extends DataMapper
{
  public function create( Member $member )
  {
    $id = $this->insert(
            "member",
            [ "business_id", "prospect_id", "status", "first_name", "last_name", "email", "phone_id", "address_1", "address_2", "city", "region", "postal_code", "country", "tuition_amount", "billing_frequency", "billing_start_date", "billing_end_date", "native_review", "google_review", "email_unsubscribe", "text_unsubscribe" ],
            [ $member->business_id, $member->prospect_id, $member->status, $member->first_name, $member->last_name, $member->email, $member->phone_id, $member->address_1, $member->address_2, $member->city, $member->region, $member->postal_code, $member->country, $member->tuition_amount, $member->billing_frequency, $member->billing_start_date, $member->billing_end_date, $member->native_review, $member->google_review, $member->email_unsubscribe, $member->text_unsubscribe ]
          );
    return $id;
  }

  public function updateMemberByID( $id, $member )
  {
      $this->update( "member", "first_name", $member->first_name, "id", $id );
      $this->update( "member", "last_name", $member->last_name, "id", $id );
      $this->update( "member", "email", $member->email, "id", $id );
      $this->update( "member", "address_1", $member->address_1, "id", $id );
      $this->update( "member", "address_2", $member->address_2, "id", $id );
      $this->update( "member", "city", $member->city, "id", $id );
      $this->update( "member", "region", $member->region, "id", $id );
  }

  public function updatePhoneIDByID( $phone_id, $id )
  {
    $this->update( "member", "phone_id", $phone_id, "id", $id );
  }

  public function updateAddressIDByID( $address_id, $id )
  {
    $this->update( "member", "address_id", $address_id, "id", $id );
  }

  public function updateGroupIDsByID( $group_ids, $id )
  {
      $this->update( "member", "group_ids", $group_ids, "id", $id );
  }

  public function mapAll()
  {
    
    $members = [];
    $sql = $this->DB->prepare( "SELECT * FROM member" );
    $sql->execute();
    while ( $resp = $sql->fetch( \PDO::FETCH_ASSOC ) ) {
      $member = $this->entityFactory->build( "Member" );
      $this->populateMember( $member, $resp );
      $members[] = $member;
    }
    return $members;
  }

  public function mapFromID( Member $member, $id )
  {
    $sql = $this->DB->prepare( "SELECT * FROM member WHERE id = :id" );
    $sql->bindParam( ":id", $id );
    $sql->execute();
    $resp = $sql->fetch( \PDO::FETCH_ASSOC );
    $this->populateMember( $member, $resp );
    return $member;
  }

  public function mapAllFromBusinessID( $business_id )
  {
    
    $members = [];
    $sql = $this->DB->prepare( 'SELECT * FROM member WHERE business_id = :business_id' );
    $sql->bindParam( ":business_id", $business_id );
    $sql->execute();
    while ( $resp = $sql->fetch( \PDO::FETCH_ASSOC ) ) {
      $member = $this->entityFactory->build( "Member" );
      $this->populateMember( $member, $resp );
      $members[] = $member;
    }

    return $members;
  }

  private function populateMember( \Model\Member $member, $data )
  {
    $member->id                      = $data[ "id" ];
    $member->business_id             = $data[ "business_id" ];
    $member->prospect_id             = $data[ "prospect_id" ];
    $member->group_ids               = $data[ "group_ids" ];
    $member->status                  = $data[ "status" ];
    $member->first_name              = $data[ "first_name" ];
    $member->last_name               = $data[ "last_name" ];
    $member->email                   = $data[ "email" ];
    $member->phone_id                = $data[ "phone_id" ];
    $member->address_id              = $data[ "address_id" ];
    $member->address_1               = $data[ "address_1" ];
    $member->address_2               = $data[ "address_2" ];
    $member->city                    = $data[ "city" ];
    $member->region                  = $data[ "region" ];
    $member->postal_code             = $data[ "postal_code" ];
    $member->country                 = $data[ "country" ];
    $member->tuition_amount          = $data[ "tuition_amount" ];
    $member->billing_frequency       = $data[ "billing_frequency" ];
    $member->billing_start_date      = $data[ "billing_start_date" ];
    $member->billing_end_date        = $data[ "billing_end_date" ];
    $member->native_review           = $data[ "native_review" ];
    $member->google_review           = $data[ "google_review" ];
    $member->email_unsubscribe       = $data[ "email_unsubscribe" ];
    $member->text_unsubscribe        = $data[ "text_unsubscribe" ];
  }

}
