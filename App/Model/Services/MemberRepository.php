<?php

namespace Model\Services;

class MemberRepository extends Repository
{
    public function save( \Model\Member $member )
    {
        $mapper = $this->getMapper();
        $id = $mapper->create( $member );

        return $id;
    }

    public function updateMemberByID( $id, \Model\Member $member )
    {
        $mapper = $this->getMapper();
        $mapper->updateMemberByID( $id, $member );
    }

    public function updatePhoneIDByID( $phone_id, $id )
    {
        $mapper = $this->getMapper();
        $mapper->updatePhoneIDByID( $phone_id, $id );

        return true;
    }

    public function updateAddressIDByID( $address_id, $id )
    {
        $mapper = $this->getMapper();
        $mapper->updateAddressIDByID( $address_id, $id );

        return true;
    }

    public function getAll()
    {
        $mapper = $this->getMapper();
        $members = $mapper->mapAll();

        return $members;
    }

    public function getByID( $id )
    {
        $mapper = $this->getMapper();
        $member = $mapper->build( $this->entityName );
        $mapper->mapFromID( $member, $id );

        return $member;
    }

    public function getAllByBusinessID( $id )
    {
        $mapper = $this->getMapper();
        $members = $mapper->mapAllFromBusinessID( $id );

        return $members;
    }

    public function updateGroupIDsByID( $group_ids, $id )
    {
        $mapper = $this->getMapper();
        $mapper->updateGroupIDsByID( $group_ids, $id );
    }
}
