<?php

namespace Model\Services;

class SequenceTemplateRepository extends Service
{
    public function create( $business_id, $name, $description )
    {
        $sequenceTemplate = new \Model\SequenceTemplate;
        $sequenceTemplateMapper = new \Model\Mappers\SequenceTemplateMapper( $this->container );
        $sequenceTemplate->business_id = $business_id;
        $sequenceTemplate->name = $name;
        $sequenceTemplate->description = $description;
        $sequenceTemplate = $sequenceTemplateMapper->create( $sequenceTemplate );

        return $sequenceTemplate;
    }

    public function getByID( $id )
    {
        $sequenceTemplate = new \Model\SequenceTemplate();
        $sequenceTemplateMapper = new \Model\Mappers\SequenceTemplateMapper( $this->container );
        $sequenceTemplateMapper->mapFromID( $sequenceTemplate, $id );

        return $sequenceTemplate;
    }

    public function getAll()
    {
        $sequenceTemplateMapper = new \Model\Mappers\SequenceTemplateMapper( $this->container );
        $sequenceTemplates = $sequenceTemplateMapper->mapAll();

        return $sequenceTemplates;
    }

    public function getAllByBusinessID( $business_id )
    {
        $sequenceTemplateMapper = new \Model\Mappers\SequenceTemplateMapper( $this->container );
        $sequenceTemplates = $sequenceTemplateMapper->mapAllFromBusinessID( $business_id );

        return $sequenceTemplates;
    }

}
