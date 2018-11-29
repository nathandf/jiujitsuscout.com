<?php

namespace Model\Services;

class EmbeddableFormRepository extends Service
{

    public function create( $business_id, $name )
    {
        $embeddableForm = new \Model\EmbeddableForm;
        $embeddableFormMapper = new \Model\Mappers\EmbeddableFormMapper( $this->container );
        $embeddableForm->name = $name;
        $embeddableForm->business_id = $business_id;
        $embeddableFormMapper->create( $embeddableForm );

        return $embeddableForm;
    }

    public function getByID( $id )
    {
        $embeddableForm = new \Model\EmbeddableForm;
        $embeddableFormMapper = new \Model\Mappers\EmbeddableFormMapper( $this->container );
        $embeddableFormMapper->mapFromID( $embeddableForm, $id );

        return $embeddableForm;
    }

    public function getByBusinessID( $id )
    {
        $embeddableForm = new \Model\EmbeddableForm;
        $embeddableFormMapper = new \Model\Mappers\EmbeddableFormMapper( $this->container );
        $embeddableFormMapper->mapFromBusinessID( $embeddableForm, $business_id );

        return $embeddableForm;
    }

    public function removeByID( $id )
    {
        $embeddableFormMapper = new \Model\Mappers\EmbeddableFormMapper( $this->container );
        $embeddableFormMapper->deleteByID( $id );
    }

}
