<?php

namespace Model\Services;

class EmbeddableFormElementTypeRepository extends Repository
{

    public function create( $name )
    {
        $mapper = $this->getMapper();
        $embeddableFormElementType = $mapper->build( $this->entityName );
        $embeddableFormElementType->name = $name;
        $mapper->create( $embeddableFormElementType );

        return $embeddableFormElementType;
    }

    public function getByID( $id )
    {
        $mapper = $this->getMapper();
        $embeddableFormElementType = $mapper->build( $this->entityName );
        $mapper->mapFromID( $embeddableFormElementType, $id );

        return $embeddableFormElementType;
    }

    public function getAll()
    {
        $mapper = $this->getMapper();
        $embeddableFormElementTypes = $mapper->mapAll();

        return $embeddableFormElementTypes;
    }

    public function removeByID( $id )
    {
        $mapper = $this->getMapper();
        $mapper->deleteByID( $id );
    }

}
