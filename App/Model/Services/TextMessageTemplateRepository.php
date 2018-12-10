<?php

namespace Model\Services;

class TextMessageTemplateRepository extends Service
{
    public function create( $business_id, $name, $description, $body )
    {
        $textMessageTemplate = new \Model\TextMessageTemplate;
        $textMessageTemplateMapper = new \Model\Mappers\TextMessageTemplateMapper( $this->container );

        $textMessageTemplate->business_id = $business_id;
        $textMessageTemplate->name = $name;
        $textMessageTemplate->description = $description;
        $textMessageTemplate->body = $body;

        $textMessageTemplate = $textMessageTemplateMapper->create( $textMessageTemplate );

        return $textMessageTemplate;
    }

    public function getAll()
    {
        $textMessageTemplateMapper = new \Model\Mappers\TextMessageTemplateMapper( $this->container );
        $textMessageTemplates = $textMessageTemplateMapper->mapAll();

        return $textMessageTemplates;
    }

    public function getAllByBusinessID( $business_id )
    {
        $textMessageTemplateMapper = new \Model\Mappers\TextMessageTemplateMapper( $this->container );
        $textMessageTemplates = $textMessageTemplateMapper->mapAllFromBusinessID( $business_id );

        return $textMessageTemplates;
    }

    public function getByID( $id )
    {
        $textMessageTemplate = new \Model\TextMessageTemplate;
        $textMessageTemplateMapper = new \Model\Mappers\TextMessageTemplateMapper( $this->container );
        $textMessageTemplateMapper->mapFromID( $textMessageTemplate, $id );

        return $textMessageTemplate;
    }

    public function updateByID( $id, $name, $description, $body )
    {
        $textMessageTemplateMapper = new \Model\Mappers\TextMessageTemplateMapper( $this->container );
        $textMessageTemplateMapper->updateByID( $id, $name, $description, $body );
    }
}
