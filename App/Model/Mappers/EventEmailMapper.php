<?php

namespace Model\Mappers;

class EventEmailMapper extends DataMapper
{
    public function mapAll()
    {
        $eventEmails = [];
        $sql = $this->DB->prepare( "SELECT * FROM event_email" );
        $sql->execute();

        while ( $resp = $sql->fetch( \PDO::FETCH_ASSOC ) ) {
            $eventEmail = $this->entityFactory->build( "EventEmail" );
            $this->populate( $eventEmail, $resp );
            $eventEmails[] = $eventEmail;
        }

        return $eventEmails;
    }

    public function mapFromID( \Model\EventEmail $eventEmail, $id )
    {
        $sql = $this->DB->prepare( "SELECT * FROM event_email WHERE id = :id" );
        $sql->bindParam( ":id", $id );
        $sql->execute();
        $resp = $sql->fetch( \PDO::FETCH_ASSOC );
        $this->populate( $eventEmail, $resp );

        return $eventEmail;
    }

    public function mapFromEventID( \Model\EventEmail $eventEmail, $id )
    {
        $sql = $this->DB->prepare( "SELECT * FROM event_email WHERE event_id = :id" );
        $sql->bindParam( ":id", $id );
        $sql->execute();
        $resp = $sql->fetch( \PDO::FETCH_ASSOC );
        $this->populate( $eventEmail, $resp );

        return $eventEmail;
    }
}
