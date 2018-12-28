<?php

namespace Model\Services;

class SequenceRepository extends Repository
{
    public function create( $business_id, $name, $description )
    {
        $mapper = $this->getMapper();
        $sequence = $mapper->build( $this->entityName );
        $sequence->business_id = $business_id;
        $sequence->name = $name;
        $sequence->description = $description;
        $sequence = $mapper->create( $sequence );

        return $sequence;
    }

    public function getByID( $id )
    {
        $mapper = $this->getMapper();
        $sequence = $mapper->build( $this->entityName );
        $mapper->mapFromID( $sequence, $id );

        return $sequence;
    }

    public function getAll()
    {
        $mapper = $this->getMapper();
        $sequences = $mapper->mapAll();

        return $sequences;
    }

    public function getAllAvailableForCheckout()
    {
        $mapper = $this->getMapper();
        $sequences = $mapper->mapAllFromCheckedOut();

        return $sequences;
    }

    public function getAllByBusinessID( $business_id )
    {
        $mapper = $this->getMapper();
        $sequences = $mapper->mapAllFromBusinessID( $business_id );

        return $sequences;
    }

    public function checkOut( $id )
    {
        $mapper = $this->getMapper();
        $mapper->updateCheckedOutByID( 1, $id );
    }

    public function checkIn( $id )
    {
        $mapper = $this->getMapper();
        $mapper->updateCheckedOutByID( 0, $id );
    }
}
