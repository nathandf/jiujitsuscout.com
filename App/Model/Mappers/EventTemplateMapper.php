<?php

namespace Model\Mappers;

class EventTemplateMapper extends DataMapper
{

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
