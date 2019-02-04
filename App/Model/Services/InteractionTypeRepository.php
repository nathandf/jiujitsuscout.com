<?php

namespace Model\Services;

class InteractionTypeRepository extends Repository
{
    public function getAll()
    {
        $mapper = $this->getMapper();
        $interactionTypes = $mapper->mapAll();

        return $interactionTypes;
    }

    public function getByID( $id )
    {
        $mapper = $this->getMapper();
        $interactionType = $mapper->build( $this->entityName );
        $mapper->mapFromID( $interactionType, $id );

        return $interactionType;
    }
}
