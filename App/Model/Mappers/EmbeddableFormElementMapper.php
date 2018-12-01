<?php

namespace Model\Mappers;

use Model\EmbeddableFormElement;

class EmbeddableFormElementMapper extends DataMapper
{

    public function create( \Model\EmbeddableFormElement $embeddableFormElement )
    {
        $id = $this->insert(
            "embeddable_form_element",
            [
                "embeddable_form_id",
                "embeddable_form_element_type_id",
                "placement",
                "text",
                "required"
            ],
            [
                $embeddableFormElement->embeddable_form_id,
                $embeddableFormElement->embeddable_form_element_type_id,
                $embeddableFormElement->placement,
                $embeddableFormElement->text,
                $embeddableFormElement->required,
            ]
        );
        $embeddableFormElement->id = $id;

        return $embeddableFormElement;
    }

    public function mapFromID( \Model\EmbeddableFormElement $embeddableFormElement, $id )
    {
        $sql = $this->DB->prepare( "SELECT * FROM embeddable_form_element WHERE id = :id" );
        $sql->bindParam( ":id", $id );
        $sql->execute();
        $resp = $sql->fetch( \PDO::FETCH_ASSOC );
        $this->populate( $embeddableFormElement, $resp );

        return $embeddableFormElement;
    }

    public function mapAllFromEmbeddableFormID( $embeddable_form_id )
    {
        $entityFactory = $this->container->getService( "entity-factory" );
        $embeddableFormElements = [];
        $sql = $this->DB->prepare( "SELECT * FROM embeddable_form_element WHERE embeddable_form_id = :embeddable_form_id" );
        $sql->bindParam( ":embeddable_form_id", $embeddable_form_id );
        $sql->execute();
        while ( $resp = $sql->fetch( \PDO::FETCH_ASSOC ) ) {
            $embeddableFormElement = $entityFactory->build( "EmbeddableFormElement" );
            $this->populate( $embeddableFormElement, $resp );

            $embeddableFormElements[] = $embeddableFormElement;
        }

        return $embeddableFormElements;
    }

    public function deleteByID( $id )
    {
        $sql = $this->DB->prepare( "DELETE FROM embeddable_form_element WHERE id = :id" );
        $sql->bindParam( ":id", $id );
        $sql->execute();
    }
}
