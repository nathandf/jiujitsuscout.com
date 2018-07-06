<?php

namespace Models\Services;

class MemberRegistrar
{
  public $memberRepo;

  public function __construct( MemberRepository $repo )
  {
    $this->memberRepo = $repo;
  }

    public function register( \Models\Member $member )
    {
        // Save member and get new id
        $member_id = $this->memberRepo->save( $member );
        $member->id = $member_id;

        return $member;
    }

    public function registerProspect( \Models\Member $member, \Models\Prospect $prospect )
    {
        $member->prospect_id            = $prospect->id;
        $member->status                 = "active";
        $member->first_name             = $prospect->first_name;
        $member->last_name              = $prospect->last_name;
        $member->email                  = $prospect->email;
        $member->phone_id               = $prospect->phone_id;
        $member->address_1              = $prospect->address_1;
        $member->address_2              = $prospect->address_2;
        $member->city                   = $prospect->city;
        $member->region                 = $prospect->region;
        $member->postal_code            = $prospect->postal_code;
        $member->country                = $prospect->country;
        $member->native_review          = $prospect->google_review_status;
        $member->google_review          = $prospect->native_review_status;
        $member->email_unsubscribe      = $prospect->unsubscribe_email;
        $member->text_unsubscribe       = $prospect->unsubscribe_text;

        $member = $this->register( $member );

        return $member;
    }

}
