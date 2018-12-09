<?php

namespace Model\Services;

class EmailTemplateRepository extends Service
{
    public function create( $business_id, $name, $description, $subject, $body )
    {
        $emailTemplate = new \Model\EmailTemplate;
        $emailTemplateMapper = new \Model\Mappers\EmailTemplateMapper( $this->container );
        $emailTemplate->business_id = $business_id;
        $emailTemplate->name = $name;
        $emailTemplate->description = $description;
        $emailTemplate->subject = $subject;
        $emailTemplate->body = $body;
        $emailTemplateMapper->create( $emailTemplate );

        return $emailTemplate;
    }

    public function getAllByBusinessID( $business_id )
    {
        $emailTemplateMapper = new \Model\Mappers\EmailTemplateMapper( $this->container );
        $emailTemplates = $emailTemplateMapper->mapAllFromBusinessID( $business_id );

        return $emailTemplates;
    }

    public function getByID( $id )
    {
        $emailTemplate = new \Model\EmailTemplate();
        $emailTemplateMapper = new \Model\Mappers\EmailTemplateMapper( $this->container );
        $emailTemplateMapper->mapFromID( $emailTemplate, $id );

        return $emailTemplate;
    }

    public function updateByID( $id, $name, $description, $subject, $body )
    {
        $emailTemplateMapper = new \Model\Mappers\EmailTemplateMapper( $this->container );
        $emailTemplateMapper->updateByID( $id, $name, $description, $subject, $body );
    }
}
