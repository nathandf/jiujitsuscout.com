<?php

namespace Model\Mappers;

class EventTemplateMapper extends DataMapper
{
    public function create( \Model\EventTemplate $eventTemplate )
    {
        $id = $this->insert(
            "event_template",
            [ "sequence_template_id", "event_type_id", "email_template_id", "text_message_template_id", "wait_duration", "placement" ],
            [ $eventTemplate->sequence_template_id, $eventTemplate->event_type_id, $eventTemplate->email_template_id, $eventTemplate->text_message_template_id, $eventTemplate->wait_duration, $eventTemplate->placement ]
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
            $eventTemplate = $entityFactory->build( "EventTemplate" );
            $this->populate( $eventTemplate, $resp );
            $eventTemplates[] = $eventTemplate;
        }

        return $eventTemplates;
    }

    public function mapAllFromSequenceTemplateID( $sequence_template_id )
    {
        $entityFactory = $this->container->getService( "entity-factory" );
        $eventTemplates = [];
        $sql = $this->DB->prepare( "SELECT * FROM event_template WHERE sequence_template_id = :sequence_template_id ORDER BY placement ASC" );
        $sql->bindParam( ":sequence_template_id", $sequence_template_id );
        $sql->execute();

        while ( $resp = $sql->fetch( \PDO::FETCH_ASSOC ) ) {
            $eventTemplate = $entityFactory->build( "EventTemplate" );
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

    public function bumpPlacementByID( $id, $direction )
    {
        if ( !in_array( $direction, [ "up", "down" ] ) ) {
            throw new \Exception( "\"$direction\" is not a valid direct. It must be either \"up\" or \"down\"." );
        }

        $entityFactory = $this->container->getService( "entity-factory" );

        // Get event template by id
        $eventTemplate = $entityFactory->build( "EventTemplate" );
        $eventTemplate = $this->mapFromID( $eventTemplate, $id );

        // Do not allow bumping placement to 0
        if ( $eventTemplate->placement == 1 && $direction == "down" ) {
            return;
        }

        switch ( $direction ) {

            case "down":
                $previous_placement = $eventTemplate->placement - 1;
                $new_placement = $eventTemplate->placement;

                // Increment placement of the previous event by one
                $sql = $this->DB->prepare( "UPDATE event_template SET placement = :new_placement WHERE placement = :previous_placement AND sequence_template_id = :sequence_template_id" );
                $sql->bindParam( ":new_placement", $new_placement );
                $sql->bindParam( ":previous_placement", $previous_placement );
                $sql->bindParam( ":sequence_template_id", $eventTemplate->sequence_template_id );
                $sql->execute();

                // Decrement the placement of the current event by one
                $sql = $this->DB->prepare( "UPDATE event_template SET placement = :previous_placement WHERE id = :id" );
                $sql->bindParam( ":id", $id );
                $sql->bindParam( ":previous_placement", $previous_placement );
                $sql->execute();

                break;

            case "up":
                $next_placement = $eventTemplate->placement + 1;
                $new_placement = $eventTemplate->placement;

                // Decrement placement of the next event by one
                $sql = $this->DB->prepare( "UPDATE event_template SET placement = :new_placement WHERE placement = :next_placement AND sequence_template_id = :sequence_template_id" );
                $sql->bindParam( ":new_placement", $new_placement );
                $sql->bindParam( ":next_placement", $next_placement );
                $sql->bindParam( ":sequence_template_id", $eventTemplate->sequence_template_id );
                $sql->execute();

                // Increment the placement of the current event by one
                $sql = $this->DB->prepare( "UPDATE event_template SET placement = :next_placement WHERE id = :id" );
                $sql->bindParam( ":id", $id );
                $sql->bindParam( ":next_placement", $next_placement );
                $sql->execute();

                break;
        }

        return;
    }
}
