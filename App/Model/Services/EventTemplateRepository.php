<?php

namespace Model\Services;

class EventTemplateRepository extends Repository
{
    public function create(
        $sequence_template_id,
        $event_type_id,
        $email_template_id = null,
        $text_message_template_id = null,
        $wait_duration = null
    ) {
        $mapper = $this->getMapper();
        $eventTemplate = $mapper->build( $this->entityName );
        $eventTemplate->sequence_template_id = $sequence_template_id;
        $eventTemplate->event_type_id = $event_type_id;
        $eventTemplate->email_template_id = $email_template_id;
        $eventTemplate->text_message_template_id = $text_message_template_id;
        $eventTemplate->wait_duration = $wait_duration;

        // Check for existing event templates. If any exist, increment the placement
        // of the last event template by one. If not, set the placement
        // for this event template as 1
        $placement = 1;

        $eventTemplates = $this->getAllBySequenceTemplateID( $sequence_template_id );
        $total_events = count( $eventTemplates );

        if ( $total_events > 0 ) {
            $placement = $total_events + 1;
        }

        $eventTemplate->placement = $placement;

        $eventTemplate = $mapper->create( $eventTemplate );

        return $eventTemplate;
    }

    public function getAll()
    {
        $mapper = $this->getMapper();
        $eventTemplates = $mapper->mapAll();

        return $eventTemplates;
    }

    public function getAllBySequenceTemplateID( $sequence_template_id )
    {
        $mapper = $this->getMapper();
        $eventTemplates = $mapper->mapAllFromSequenceTemplateID( $sequence_template_id );

        return $eventTemplates;
    }

    public function getByID( $id )
    {
        $mapper = $this->getMapper();
        $eventTemplate = $mapper->build( $this->entityName );
        $mapper->mapFromID( $eventTemplate, $id );

        return $eventTemplate;
    }

    public function bumpPlacementByID( $id, $bump_direction )
    {
        $mapper = $this->getMapper();
        $mapper->bumpPlacementByID( $id, $bump_direction );
    }
}
