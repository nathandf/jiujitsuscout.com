<?php

namespace Model\Services;

class MemberRepository extends Service
{

  public function save( \Model\Member $member )
  {
    $memberMapper = new \Model\Mappers\MemberMapper( $this->container );
    $id = $memberMapper->create( $member );

    return $id;
  }

  public function updateMemberByID( $id, \Model\Member $member )
  {
    $memberMapper = new \Model\Mappers\MemberMapper( $this->container );
    $memberMapper->updateMemberByID( $id, $member );
  }

  public function updatePhoneIDByID( $phone_id, $id )
  {
    $memberMapper = new \Model\Mappers\MemberMapper( $this->container );
    $memberMapper->updatePhoneIDByID( $phone_id, $id );

    return true;
  }

  public function updateAddressIDByID( $address_id, $id )
  {
    $memberMapper = new \Model\Mappers\MemberMapper( $this->container );
    $memberMapper->updateAddressIDByID( $address_id, $id );

    return true;
  }

  public function getAll()
  {
    $memberMapper = new \Model\Mappers\MemberMapper( $this->container );
    $members = $memberMapper->mapAll();
    return $members;
  }

  public function getByID( $id )
  {
    $member = new \Model\Member;
    $memberMapper = new \Model\Mappers\MemberMapper( $this->container );
    $memberMapper->mapFromID( $member, $id );

    return $member;
  }

  public function getAllByBusinessID( $id )
  {
    $memberMapper = new \Model\Mappers\MemberMapper( $this->container );
    $members = $memberMapper->mapAllFromBusinessID( $id );
    return $members;
  }

    public function updateGroupIDsByID( $group_ids, $id )
    {
        $memberMapper = new \Model\Mappers\MemberMapper( $this->container );
        $memberMapper->updateGroupIDsByID( $group_ids, $id );
    }

}
