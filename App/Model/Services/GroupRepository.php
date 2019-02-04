<?php

namespace Model\Services;

class GroupRepository extends Repository
{

    public function create( $business_id, $name, $description )
    {
        $mapper = $this->getMapper();
        $group = $mapper->build( $this->entityName );
        $group->business_id = $business_id;
        $group->name = $name;
        $group->description = $description;
        $mapper->create( $group );

        return $group;
    }

    public function getByID( $id )
    {
        $mapper = $this->getMapper();
        $group = $mapper->build( $this->entityName );
        $mapper->mapFromID( $group, $id );

        return $group;
    }

    public function getAllByBusinessID( $business_id )
    {
        $mapper = $this->getMapper();
        $groups = $mapper->mapAllFromBusinessID( $business_id );

        return $groups;
    }

    public function updateGroupByID( $group_id, $name, $description )
    {
        $mapper = $this->getMapper();
        $mapper->updateGroupByID( $group_id, $name, $description );
    }

    public function removeByID( $id )
    {
        $mapper = $this->getMapper();
        $mapper->delete( [ "id" ], [ $id ] );
    }

}
