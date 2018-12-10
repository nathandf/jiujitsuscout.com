<?php

namespace Model\Mappers;

class EventTemplateMapper extends DataMapper
{
    public function create( \Model\EventTemplate $eventTemplate )
    {
        $id = $this->insert(
            "event_template",
            [ "sequence_template_id", "event_type_id", "email_template_id", "text_message_template_id", "wait_duration" ],
            [ $eventTemplate->sequence_template_id, $eventTemplate->event_type_id, $eventTemplate->email_template_id, $eventTemplate->text_message_template_id, $eventTemplate->wait_duration ]
        );

        $eventTemplate->id = $id;

        return $eventTemplate;
    }

    public function mapAll()
    {
        $entityFactory = $this->container->getService( "entity-factory" );
        $eventTemplates = [];
        $sql = $this->DB->prepare( "SELECT * FROM event_template" );
        $sql->execute();

        while ( $resp = $sql->fetch( \PDO::FETCH_ASSOC ) ) {
            $this->populate( $eventTemplate, $resp );
            $eventTemplates[] = $eventTemplate;
        }

        return $eventTemplates;
    }

    public function mapAllFromSequenceTemplateID( $sequence_template_id )
    {
        $entityFactory = $this->container->getService( "entity-factory" );
        $eventTemplates = [];
        $sql = $this->DB->prepare( "SELECT * FROM event_template WHERE sequence_template_id = :sequence_template_id" );
        $sql->bindParam( ":sequence_template_id", $sequence_template_id );
        $sql->execute();

        while ( $resp = $sql->fetch( \PDO::FETCH_ASSOC ) ) {
            $this->populate( $eventTemplate, $resp );
            $eventTemplates[] = $eventTemplate;
        }

        return $eventTemplates;
    }

    public function mapFromID( \Model\EventTemplate $eventTemplate, $id )
    {
        $sql = $this->DB->prepare( "SELECT * FROM event_template WHERE id = :id" );
        $sql->bindParam( ":id", $id );
        $sql->execute();
        $resp = $sql->fetch( \PDO::FETCH_ASSOC );
        $this->populate( $eventTemplate, $resp );

        return $eventTemplate;
    }
}
