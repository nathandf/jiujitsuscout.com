<?php

namespace Model\Mappers;

class EventTypeMapper extends DataMapper
{
    public function mapAll()
    {
        $eventTypes = [];
        $sql = $this->DB->prepare( "SELECT * FROM event_type" );
        $sql->execute();

        while ( $resp = $sql->fetch( \PDO::FETCH_ASSOC ) ) {
            $eventType = $this->entityFactory->build( "EventType" );
            $this->populate( $eventType, $resp );
            $eventTypes[] = $eventType;
        }

        return $eventTypes;
    }

    public function mapFromID( \Model\EventType $eventType, $id )
    {
        $sql = $this->DB->prepare( "SELECT * FROM event_type WHERE id = :id" );
        $sql->bindParam( ":id", $id );
        $sql->execute();
        $resp = $sql->fetch( \PDO::FETCH_ASSOC );
        $this->populate( $eventType, $resp );

        return $eventType;
    }
}
