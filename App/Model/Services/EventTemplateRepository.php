<?php

namespace Model\Services;

class EventTemplateRepository extends Service
{
    public function getAll()
    {
        $eventTemplateMapper = new \Model\Mappers\EventTemplateMapper( $this->container );
        $eventTemplates = $eventTemplateMapper->mapAll();

        return $eventTemplates;
    }

    public function getAllBySequenceTemplateID( $sequence_template_id )
    {
        $eventTemplateMapper = new \Model\Mappers\EventTemplateMapper( $this->container );
        $eventTemplates = $eventTemplateMapper->mapAllFromSequenceTemplateID( $sequence_template_id );

        return $eventTemplates;
    }

    public function getByID( $id )
    {
        $eventTemplate = new \Model\EventTemplate();
        $eventTemplateMapper = new \Model\Mappers\EventTemplateMapper( $this->container );
        $eventTemplateMapper->mapFromID( $eventTemplate, $id );

        return $eventTemplate;
    }
}
