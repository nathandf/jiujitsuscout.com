<?php

namespace Model\Services;

class EmbeddableFormRepository extends Repository
{

    public function create( $business_id, $name, $offer = null )
    {
        $mapper = $this->getMapper();
        $embeddableForm = $mapper->build( $this->entityName );
        $embeddableForm->name = $name;
        $embeddableForm->business_id = $business_id;
        $embeddableForm->offer = $offer;
        $embeddableForm->token = md5( base64_encode( openssl_random_pseudo_bytes( 32 ) ) );
        $mapper->create( $embeddableForm );

        return $embeddableForm;
    }

    public function getByID( $id )
    {
        $mapper = $this->getMapper();
        $embeddableForm = $mapper->build( $this->entityName );
        $mapper->mapFromID( $embeddableForm, $id );

        return $embeddableForm;
    }

    public function getByToken( $token )
    {
        $mapper = $this->getMapper();
        $embeddableForm = $mapper->build( $this->entityName );
        $mapper->mapFromToken( $embeddableForm, $token );

        return $embeddableForm;
    }

    public function getAllByBusinessID( $business_id )
    {
        $mapper = $this->getMapper();
        $embeddableForms = $mapper->mapAllFromBusinessID( $business_id );

        return $embeddableForms;
    }

    public function removeByID( $id )
    {
        $mapper = $this->getMapper();
        $mapper->deleteByID( $id );
    }

}
