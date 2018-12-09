<?php

namespace Model\Mappers;

class SequenceMapper extends DataMapper
{
    public function create( \Model\Sequence $sequence )
    {
        $id = $this->insert(
            "sequence",
            [ "business_id", "name", "description" ],
            [ $sequence->business_id, $sequence->name, $sequence->description ]
        );
        $sequence->id = $id;

        return $sequence;
    }

    public function mapFromID( \Model\Sequence $sequence, $id )
    {
        $sql = $this->DB->prepare( "SELECT * FROM sequence WHERE id = :id" );
        $sql->bindParam( ":id", $id );
        $sql->execute();
        $resp = $sql->fetch( \PDO::FETCH_ASSOC );
        $this->populate( $sequence, $resp );

        return $sequence;
    }

    public function mapAll()
    {
        $entityFactory = $this->container->getService( "entity-factory" );
        $sequences = [];
        $sql = $this->DB->prepare( "SELECT * FROM sequence" );
        $sql->execute();

        while ( $resp = $sql->fetch( \PDO::FETCH_ASSOC ) ) {
            $sequence = $entityFactory->build( "Sequence" );
            $this->populate( $sequence, $resp );
            $sequences[] = $sequence;
        }

        return $sequences;
    }

    public function mapAllFromBusinessID( $business_id )
    {
        $entityFactory = $this->container->getService( "entity-factory" );
        $sequences = [];
        $sql = $this->DB->prepare( "SELECT * FROM sequence WHERE business_id = :business_id" );
        $sql->bindParam( "business_id", $business_id );
        $sql->execute();

        while ( $resp = $sql->fetch( \PDO::FETCH_ASSOC ) ) {
            $sequence = $entityFactory->build( "Sequence" );
            $this->populate( $sequence, $resp );
            $sequences[] = $sequence;
        }

        return $sequences;
    }

    public function mapAllFromCheckedOut()
    {
        $checked_out = 0;
        $entityFactory = $this->container->getService( "entity-factory" );
        $sequences = [];
        $sql = $this->DB->prepare( "SELECT * FROM sequence WHERE checked_out = :checked_out" );
        $sql->bindParam( ":checked_out", $checked_out );
        $sql->execute();

        while ( $resp = $sql->fetch( \PDO::FETCH_ASSOC ) ) {
            $sequence = $entityFactory->build( "Sequence" );
            $this->populate( $sequence, $resp );
            $sequences[] = $sequence;
        }

        return $sequences;
    }

    public function updateByID( $id, $name, $description )
    {
        $this->update( "sequence", "name", $name, "id", $id );
        $this->update( "sequence", "description", $description, "id", $id );
    }

    public function updateCheckedOutByID( $checked_out, $id )
    {
        $this->update( "sequence", "checked_out", $checked_out, "id", $id );
    }

}
