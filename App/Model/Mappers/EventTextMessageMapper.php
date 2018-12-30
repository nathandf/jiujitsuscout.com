<?php

namespace Model\Mappers;

class EventTextMessageMapper extends DataMapper
{
    public function mapAll()
    {
        $eventTextMessages = [];
        $sql = $this->DB->prepare( "SELECT * FROM event_text_message" );
        $sql->execute();

        while ( $resp = $sql->fetch( \PDO::FETCH_ASSOC ) ) {
            $eventTextMessage = $this->entityFactory->build( "EventTextMessage" );
            $this->populate( $eventTextMessage, $resp );
            $eventTextMessages[] = $eventTextMessage;
        }

        return $eventTextMessages;
    }

    public function mapFromID( \Model\EventTextMessage $eventTextMessage, $id )
    {
        $sql = $this->DB->prepare( "SELECT * FROM event_text_message WHERE id = :id" );
        $sql->bindParam( ":id", $id );
        $sql->execute();
        $resp = $sql->fetch( \PDO::FETCH_ASSOC );
        $this->populate( $eventTextMessage, $resp );

        return $eventTextMessage;
    }

    public function mapFromEventID( \Model\EventTextMessage $eventTextMessage, $id )
    {
        $sql = $this->DB->prepare( "SELECT * FROM event_text_message WHERE event_id = :id" );
        $sql->bindParam( ":id", $id );
        $sql->execute();
        $resp = $sql->fetch( \PDO::FETCH_ASSOC );
        $this->populate( $eventTextMessage, $resp );

        return $eventTextMessage;
    }
}
