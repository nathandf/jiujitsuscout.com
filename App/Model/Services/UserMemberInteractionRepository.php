<?php

namespace Model\Services;

class UserMemberInteractionRepository extends Repository
{
    public function getAll()
    {
        $mapper = $this->getMapper();
        $userProspectInteractions = $mapper->mapAll();

        return $userProspectInteractions;
    }

    public function getByID( $id )
    {
        $mapper = $this->getMapper();
        $userProspectInteraction = $mapper->build( $this->entityName );
        $mapper->mapFromID( $userProspectInteraction, $id );

        return $userProspectInteraction;
    }

    public function getByUserID( $id )
    {
        $mapper = $this->getMapper();
        $userProspectInteraction = $mapper->build( $this->entityName );
        $mapper->mapFromUserID( $userProspectInteraction, $id );

        return $userProspectInteraction;
    }

    public function getByMemberID( $id )
    {
        $mapper = $this->getMapper();
        $userProspectInteraction = $mapper->build( $this->entityName );
        $mapper->mapFromMemberID( $userProspectInteraction, $id );

        return $userProspectInteraction;
    }
}
