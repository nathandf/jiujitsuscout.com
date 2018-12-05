<?php

namespace Model\Services;

class EmbeddableFormElementTypeRepository extends Service
{

    public function create( $name )
    {
        $embeddableFormElementType = new \Model\EmbeddableFormElementType;
        $embeddableFormElementTypeMapper = new \Model\Mappers\EmbeddableFormElementTypeMapper( $this->container );
        $embeddableFormElementType->name = $name;
        $embeddableFormElementTypeMapper->create( $embeddableFormElementType );

        return $embeddableFormElementType;
    }

    public function getByID( $id )
    {
        $embeddableFormElementType = new \Model\EmbeddableFormElementType;
        $embeddableFormElementTypeMapper = new \Model\Mappers\EmbeddableFormElementTypeMapper( $this->container );
        $embeddableFormElementTypeMapper->mapFromID( $embeddableFormElementType, $id );

        return $embeddableFormElementType;
    }

    public function getAll()
    {
        $embeddableFormElementTypeMapper = new \Model\Mappers\EmbeddableFormElementTypeMapper( $this->container );
        $embeddableFormElementTypes = $embeddableFormElementTypeMapper->mapAll();

        return $embeddableFormElementTypes;
    }

    public function removeByID( $id )
    {
        $embeddableFormElementTypeMapper = new \Model\Mappers\EmbeddableFormElementTypeMapper( $this->container );
        $embeddableFormElementTypeMapper->deleteByID( $id );
    }

}
