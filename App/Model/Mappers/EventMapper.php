<?php

namespace Model\Mappers;

class EventMapper extends DataMapper
{
    public function mapAll()
    {
        $events = [];
        $sql = $this->DB->prepare( "SELECT * FROM event" );
        $sql->execute();

        while ( $resp = $sql->fetch( \PDO::FETCH_ASSOC ) ) {
            $this->populate( $event, $resp );
            $events[] = $event;
        }

        return $events;
    }

    public function mapAllFromSequenceID( $sequence_id )
    {
        $events = [];
        $sql = $this->DB->prepare( "SELECT * FROM event WHERE sequence_id = :sequence_id" );
        $sql->bindParam( ":sequence_id", $sequence_id );
        $sql->execute();

        while ( $resp = $sql->fetch( \PDO::FETCH_ASSOC ) ) {
            $this->populate( $event, $resp );
            $events[] = $event;
        }

        return $events;
    }

    public function mapAllFromBusinessID( $busines_id )
    {
        $events = [];
        $sql = $this->DB->prepare( "SELECT * FROM event WHERE business_id = :business_id" );
        $sql->bindParam( ":business_id", $business_id );
        $sql->execute();

        while ( $resp = $sql->fetch( \PDO::FETCH_ASSOC ) ) {
            $this->populate( $event, $resp );
            $events[] = $event;
        }

        return $events;
    }

    public function mapFromID( \Model\Event $event, $id )
    {
        $sql = $this->DB->prepare( "SELECT * FROM event WHERE id = :id" );
        $sql->bindParam( ":id", $id );
        $sql->execute();
        $resp = $sql->fetch( \PDO::FETCH_ASSOC );
        $this->populate( $event, $resp );

        return $event;
    }
}
