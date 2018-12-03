<?php

namespace Model\Mappers;

use Model\EmbeddableForm;

class EmbeddableFormMapper extends DataMapper
{

    public function create( \Model\EmbeddableForm $embeddableForm )
    {
        $id = $this->insert(
            "embeddable_form",
            [ "business_id", "name", "offer" ],
            [ $embeddableForm->business_id, $embeddableForm->name, $embeddableForm->offer ]
        );
        $embeddableForm->id = $id;

        return $embeddableForm;
    }

    public function mapFromID( \Model\EmbeddableForm $embeddableForm, $id )
    {
        $sql = $this->DB->prepare( "SELECT * FROM embeddable_form WHERE id = :id" );
        $sql->bindParam( ":id", $id );
        $sql->execute();
        $resp = $sql->fetch( \PDO::FETCH_ASSOC );
        $this->populate( $embeddableForm, $resp );

        return $embeddableForm;
    }

    public function mapAllFromBusinessID( $business_id )
    {
        $entityFactory = $this->container->getService( "entity-factory" );
        $embeddableForms = [];
        $sql = $this->DB->prepare( "SELECT * FROM embeddable_form WHERE business_id = :business_id" );
        $sql->bindParam( ":business_id", $business_id );
        $sql->execute();
        while ( $resp = $sql->fetch( \PDO::FETCH_ASSOC ) ) {
            $embeddableForm = $entityFactory->build( "EmbeddableForm" );
            $this->populate( $embeddableForm, $resp );

            $embeddableForms[] = $embeddableForm;
        }

        return $embeddableForms;
    }

    public function deleteByID( $id )
    {
        $sql = $this->DB->prepare( "DELETE FROM embeddable_form WHERE id = :id" );
        $sql->bindParam( ":id", $id );
        $sql->execute();
    }
}
