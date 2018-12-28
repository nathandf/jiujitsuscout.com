<?php

namespace Model\Services;

class UserProspectInteractionRepository extends Repository
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

    public function getByProspectID( $id )
    {
        $mapper = $this->getMapper();
        $userProspectInteraction = $mapper->build( $this->entityName );
        $mapper->mapFromProspectID( $userProspectInteraction, $id );

        return $userProspectInteraction;
    }
}
