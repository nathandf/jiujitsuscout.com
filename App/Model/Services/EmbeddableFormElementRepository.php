<?php

namespace Model\Services;

class EmbeddableFormElementRepository extends Service
{

    public function create( $embeddable_form_id, $embeddable_form_element_type_id, $placement, $text, $required = false )
    {
        $embeddableFormElement = new \Model\EmbeddableFormElement;
        $embeddableFormElementMapper = new \Model\Mappers\EmbeddableFormElementMapper( $this->container );
        $embeddableFormElement->embeddable_form_id = $embeddable_form_id;
        $embeddableFormElement->embeddable_form_element_type_id = $embeddable_form_element_type_id;
        $embeddableFormElement->placement = $placement;
        $embeddableFormElement->text = $text;
        $embeddableFormElement->required = $required ? 1 : 0;
        $embeddableFormElementMapper->create( $embeddableFormElement );

        return $embeddableFormElement;
    }

    public function getByID( $id )
    {
        $embeddableFormElement = new \Model\EmbeddableFormElement;
        $embeddableFormElementMapper = new \Model\Mappers\EmbeddableFormElementMapper( $this->container );
        $embeddableFormElementMapper->mapFromID( $embeddableFormElement, $id );

        return $embeddableFormElement;
    }

    public function getAllByEmbeddableFormID( $embeddable_form_id )
    {
        $embeddableFormElement = new \Model\EmbeddableFormElement;
        $embeddableFormElementMapper = new \Model\Mappers\EmbeddableFormElementMapper( $this->container );
        $embeddableFormElementMapper->mapAllFromEmbeddableFormID( $embeddableFormElement, $embeddable_form_id );

        return $embeddableFormElement;
    }

    public function removeByID( $id )
    {
        $embeddableFormElementMapper = new \Model\Mappers\EmbeddableFormElementMapper( $this->container );
        $embeddableFormElementMapper->deleteByID( $id );
    }

}
