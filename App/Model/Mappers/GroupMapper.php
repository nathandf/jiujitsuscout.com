<?php

namespace Model\Mappers;

use Model\Group;

class GroupMapper extends DataMapper
{

    public function create( \Model\Group $group )
    {
        $id = $this->insert(
            "`group`",
            [ "business_id", "name", "description" ],
            [ $group->business_id, $group->name, $group->description ]
        );
        $group->id = $id;

        return $group;
    }

    public function mapFromID( Group $group, $id )
    {
        $sql = $this->DB->prepare( "SELECT * FROM `group` WHERE id = :id" );
        $sql->bindParam( ":id", $id );
        $sql->execute();
        $resp = $sql->fetch( \PDO::FETCH_ASSOC );
        $this->populateGroup( $group, $resp );

        return $group;
    }

    public function mapAllFromBusinessID( $business_id )
    {
        
        $groups = [];
        $sql = $this->DB->prepare( "SELECT * FROM `group` WHERE business_id = :business_id" );
        $sql->bindParam( ":business_id", $business_id );
        $sql->execute();
        while ( $resp = $sql->fetch( \PDO::FETCH_ASSOC ) ) {
        $group = $this->entityFactory->build( "Group" );
        $this->populateGroup( $group, $resp );

        $groups[] = $group;
        }

        return $groups;
    }


    public function updateDescriptionByID( $id, $description )
    {
        $this->update( "`group`", "description", $description, "id", $id );
    }

    public function updateNameByID( $id, $name )
    {
        $this->update( "`group`", "name", $name, "id", $id );
    }

    public function updateGroupByID( $id, $name, $description )
    {
        $this->update( "`group`", "name", $name, "id", $id );
        $this->update( "`group`", "description", $description, "id", $id );
    }

    public function delete( $id )
    {
        $sql = $this->DB->prepare( "DELETE FROM `group` WHERE id = :id" );
        $sql->bindParam( ":id", $id );
        $sql->execute();
    }

    public function populateGroup( $group, $data )
    {
        $group->id                          = $data[ "id" ];
        $group->business_id                 = $data[ "business_id" ];
        $group->name                        = $data[ "name" ];
        $group->description                 = $data[ "description" ];
    }

}
