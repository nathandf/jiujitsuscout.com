<?php

namespace Model\Services;

class EmailTemplateRepository extends Repository
{
    public function create( $business_id, $name, $description, $subject, $body )
    {
        $mapper = $this->getMapper();
        $emailTemplate = $mapper->build( $this->entityName );
        $emailTemplate->business_id = $business_id;
        $emailTemplate->name = $name;
        $emailTemplate->description = $description;
        $emailTemplate->subject = $subject;
        $emailTemplate->body = $body;
        $mapper->create( $emailTemplate );

        return $emailTemplate;
    }

    public function getAllByBusinessID( $business_id )
    {
        $mapper = $this->getMapper();
        $emailTemplates = $mapper->mapAllFromBusinessID( $business_id );

        return $emailTemplates;
    }

    public function getByID( $id )
    {
        $mapper = $this->getMapper();
        $emailTemplate = $mapper->build( $this->entityName );
        $mapper->mapFromID( $emailTemplate, $id );

        return $emailTemplate;
    }

    public function updateByID( $id, $name, $description, $subject, $body )
    {
        $mapper = $this->getMapper();
        $mapper->updateByID( $id, $name, $description, $subject, $body );
    }
}
