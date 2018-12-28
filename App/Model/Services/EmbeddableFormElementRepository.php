<?php

namespace Model\Services;

class EmbeddableFormElementRepository extends Repository
{

    public function create( $embeddable_form_id, $embeddable_form_element_type_id, $placement, $text = null, $required = false )
    {
        $mapper = $this->getMapper();
        $embeddableFormElement = $mapper->build( $this->entityName );
        $embeddableFormElement->embeddable_form_id = $embeddable_form_id;
        $embeddableFormElement->embeddable_form_element_type_id = $embeddable_form_element_type_id;
        $embeddableFormElement->placement = $placement;
        $embeddableFormElement->text = $text;
        $embeddableFormElement->required = $required ? 1 : 0;
        $mapper->create( $embeddableFormElement );

        return $embeddableFormElement;
    }

    public function getByID( $id )
    {
        $mapper = $this->getMapper();
        $embeddableFormElement = $mapper->build( $this->entityName );
        $mapper->mapFromID( $embeddableFormElement, $id );

        return $embeddableFormElement;
    }

    public function getAllByEmbeddableFormID( $embeddable_form_id )
    {
        $mapper = $this->getMapper();
        $embeddableFormElements = $mapper->mapAllFromEmbeddableFormID( $embeddable_form_id );

        return $embeddableFormElements;
    }

    public function removeByID( $id )
    {
        $mapper = $this->getMapper();
        $mapper->deleteByID( $id );
    }

}
