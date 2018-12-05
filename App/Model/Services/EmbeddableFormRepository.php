<?php

namespace Model\Services;

class EmbeddableFormRepository extends Service
{

    public function create( $business_id, $name, $offer = null )
    {
        $embeddableForm = new \Model\EmbeddableForm;
        $embeddableFormMapper = new \Model\Mappers\EmbeddableFormMapper( $this->container );
        $embeddableForm->name = $name;
        $embeddableForm->business_id = $business_id;
        $embeddableForm->offer = $offer;
        $embeddableForm->token = md5( base64_encode( openssl_random_pseudo_bytes( 32 ) ) );
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

    public function getByToken( $token )
    {
        $embeddableForm = new \Model\EmbeddableForm;
        $embeddableFormMapper = new \Model\Mappers\EmbeddableFormMapper( $this->container );
        $embeddableFormMapper->mapFromToken( $embeddableForm, $token );

        return $embeddableForm;
    }

    public function getAllByBusinessID( $business_id )
    {
        $embeddableFormMapper = new \Model\Mappers\EmbeddableFormMapper( $this->container );
        $embeddableForms = $embeddableFormMapper->mapAllFromBusinessID( $business_id );

        return $embeddableForms;
    }

    public function removeByID( $id )
    {
        $embeddableFormMapper = new \Model\Mappers\EmbeddableFormMapper( $this->container );
        $embeddableFormMapper->deleteByID( $id );
    }

}
