<?php

namespace Model\Services;

class EventTemplateRepository extends Service
{
    public function create(
        $sequence_template_id,
        $event_type_id,
        $email_template_id = null,
        $text_message_template_id = null,
        $wait_duration = null
    ) {
        $eventTemplate = new \Model\EventTemplate;
        $eventTemplateMapper = new \Model\Mappers\EventTemplateMapper( $this->container );
        $eventTemplate->sequence_template_id = $sequence_template_id;
        $eventTemplate->event_type_id = $event_type_id;
        $eventTemplate->email_template_id = $email_template_id;
        $eventTemplate->text_message_template_id = $text_message_template_id;
        $eventTemplate->wait_duration = $wait_duration;

        $eventTemplate = $eventTemplateMapper->create( $eventTemplate );

        return $eventTemplate;
    }

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
