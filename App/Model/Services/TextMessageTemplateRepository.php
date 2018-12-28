<?php

namespace Model\Services;

class TextMessageTemplateRepository extends Repository
{
    public function create( $business_id, $name, $description, $body )
    {
        $mapper = $this->getMapper();
        $textMessageTemplate = $mapper->build( $this->entityName );

        $textMessageTemplate->business_id = $business_id;
        $textMessageTemplate->name = $name;
        $textMessageTemplate->description = $description;
        $textMessageTemplate->body = $body;

        $textMessageTemplate = $mapper->create( $textMessageTemplate );

        return $textMessageTemplate;
    }

    public function getAll()
    {
        $mapper = $this->getMapper();
        $textMessageTemplates = $mapper->mapAll();

        return $textMessageTemplates;
    }

    public function getAllByBusinessID( $business_id )
    {
        $mapper = $this->getMapper();
        $textMessageTemplates = $mapper->mapAllFromBusinessID( $business_id );

        return $textMessageTemplates;
    }

    public function getByID( $id )
    {
        $mapper = $this->getMapper();
        $textMessageTemplate = $mapper->build( $this->entityName );
        $mapper->mapFromID( $textMessageTemplate, $id );

        return $textMessageTemplate;
    }

    public function updateByID( $id, $name, $description, $body )
    {
        $mapper = $this->getMapper();
        $mapper->updateByID( $id, $name, $description, $body );
    }
}
