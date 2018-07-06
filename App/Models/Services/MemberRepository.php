<?php

namespace Models\Services;

class MemberRepository extends Service
{

  public function save( \Models\Member $member )
  {
    $memberMapper = new \Models\Mappers\MemberMapper( $this->container );
    $id = $memberMapper->create( $member );

    return $id;
  }

  public function updateMemberByID( $id, \Models\Member $member )
  {
    $memberMapper = new \Models\Mappers\MemberMapper( $this->container );
    $memberMapper->updateMemberByID( $id, $member );
  }

  public function updatePhoneIDByID( $phone_id, $id )
  {
    $memberMapper = new \Models\Mappers\MemberMapper( $this->container );
    $memberMapper->updatePhoneIDByID( $phone_id, $id );

    return true;
  }

  public function updateAddressIDByID( $address_id, $id )
  {
    $memberMapper = new \Models\Mappers\MemberMapper( $this->container );
    $memberMapper->updateAddressIDByID( $address_id, $id );

    return true;
  }

  public function getAll()
  {
    $memberMapper = new \Models\Mappers\MemberMapper( $this->container );
    $members = $memberMapper->mapAll();
    return $members;
  }

  public function getByID( $id )
  {
    $member = new \Models\Member;
    $memberMapper = new \Models\Mappers\MemberMapper( $this->container );
    $memberMapper->mapFromID( $member, $id );

    return $member;
  }

  public function getAllByBusinessID( $id )
  {
    $memberMapper = new \Models\Mappers\MemberMapper( $this->container );
    $members = $memberMapper->mapAllFromBusinessID( $id );
    return $members;
  }

    public function updateGroupIDsByID( $group_ids, $id )
    {
        $memberMapper = new \Models\Mappers\MemberMapper( $this->container );
        $memberMapper->updateGroupIDsByID( $group_ids, $id );
    }

}
