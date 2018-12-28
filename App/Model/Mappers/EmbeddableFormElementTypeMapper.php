<?php

namespace Model\Mappers;

use Model\EmbeddableFormElementType;

class EmbeddableFormElementTypeMapper extends DataMapper
{

    public function create( \Model\EmbeddableFormElementType $embeddableFormElementType )
    {
        $id = $this->insert(
            "embeddable_form_element_type",
            [ "name" ],
            [ $embeddableFormElementType->name ]
        );
        $embeddableFormElementType->id = $id;

        return $embeddableFormElementType;
    }

    public function mapFromID( \Model\EmbeddableFormElementType $embeddableFormElementType, $id )
    {
        $sql = $this->DB->prepare( "SELECT * FROM embeddable_form_element_type WHERE id = :id" );
        $sql->bindParam( ":id", $id );
        $sql->execute();
        $resp = $sql->fetch( \PDO::FETCH_ASSOC );
        $this->populate( $embeddableFormElementType, $resp );

        return $embeddableFormElementType;
    }

    public function mapAll()
    {
        
        $embeddableFormElementTypes = [];
        $sql = $this->DB->prepare( "SELECT * FROM embeddable_form_element_type" );
        $sql->execute();
        while ( $resp = $sql->fetch( \PDO::FETCH_ASSOC ) ) {
            $embeddableFormElementType = $this->entityFactory->build( "EmbeddableFormElementType" );
            $this->populate( $embeddableFormElementType, $resp );
            $embeddableFormElementTypes[] = $embeddableFormElementType;
        }

        return $embeddableFormElementTypes;
    }

    public function deleteByID( $id )
    {
        $sql = $this->DB->prepare( "DELETE FROM embeddable_form_element_type WHERE id = :id" );
        $sql->bindParam( ":id", $id );
        $sql->execute();
    }
}
