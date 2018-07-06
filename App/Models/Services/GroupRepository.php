<?php

namespace Models\Services;

class GroupRepository extends Service
{

    public function create( $business_id, $name, $description )
    {
        $group = new \Models\Group();
        $groupMapper = new \Models\Mappers\GroupMapper( $this->container );
        $group->business_id = $business_id;
        $group->name = $name;
        $group->description = $description;
        $groupMapper->create( $group );

        return $group;
    }

    public function getByID( $id )
    {
        $group = new \Models\Group();
        $groupMapper = new \Models\Mappers\GroupMapper( $this->container );
        $groupMapper->mapFromID( $group, $id );

        return $group;
    }

    public function getAllByBusinessID( $business_id )
    {
        $groupMapper = new \Models\Mappers\GroupMapper( $this->container );
        $groups = $groupMapper->mapAllFromBusinessID( $business_id );

        return $groups;
    }

    public function updateGroupByID( $group_id, $name, $description )
    {
        $groupMapper = new \Models\Mappers\GroupMapper( $this->container );
        $groupMapper->updateGroupByID( $group_id, $name, $description );
    }

    public function removeByID( $id )
    {
        $groupMapper = new \Models\Mappers\GroupMapper( $this->container );
        $groupMapper->delete( $id );
    }

}
