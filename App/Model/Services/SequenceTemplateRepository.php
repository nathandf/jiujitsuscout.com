<?php

namespace Model\Services;

class SequenceTemplateRepository extends Repository
{
    public function create( $business_id, $name, $description )
    {
        $mapper = $this->getMapper();
        $sequenceTemplate = $mapper->build( $this->entityName );
        $sequenceTemplate->business_id = $business_id;
        $sequenceTemplate->name = $name;
        $sequenceTemplate->description = $description;
        $sequenceTemplate = $mapper->create( $sequenceTemplate );

        return $sequenceTemplate;
    }

    public function getByID( $id )
    {
        $mapper = $this->getMapper();
        $sequenceTemplate = $mapper->build( $this->entityName );
        $mapper->mapFromID( $sequenceTemplate, $id );

        return $sequenceTemplate;
    }

    public function getAll()
    {
        $mapper = $this->getMapper();
        $sequenceTemplates = $mapper->mapAll();

        return $sequenceTemplates;
    }

    public function getAllByBusinessID( $business_id )
    {
        $mapper = $this->getMapper();
        $sequenceTemplates = $mapper->mapAllFromBusinessID( $business_id );

        return $sequenceTemplates;
    }

    public function updateByID( $id, $name, $description )
    {
        $mapper = $this->getMapper();
        $mapper->updateByID( $id, $name, $description );
    }
}
