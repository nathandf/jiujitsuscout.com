<?php

namespace Model\Services;

class SequenceRepository extends Service
{
    public function create( $business_id, $name, $description )
    {
        $sequence = new \Model\Sequence;
        $sequenceMapper = new \Model\Mappers\SequenceMapper( $this->container );
        $sequence->business_id = $business_id;
        $sequence->name = $name;
        $sequence->description = $description;
        $sequence = $sequenceMapper->create( $sequence );

        return $sequence;
    }
    
    public function getByID( $id )
    {
        $sequence = new \Model\Sequence();
        $sequenceMapper = new \Model\Mappers\SequenceMapper( $this->container );
        $sequenceMapper->mapFromID( $sequence, $id );

        return $sequence;
    }

    public function getAll()
    {
        $sequenceMapper = new \Model\Mappers\SequenceMapper( $this->container );
        $sequences = $sequenceMapper->mapAll();

        return $sequences;
    }

    public function getAllAvailableForCheckout()
    {
        $sequenceMapper = new \Model\Mappers\SequenceMapper( $this->container );
        $sequences = $sequenceMapper->mapAllFromCheckedOut();

        return $sequences;
    }

    public function getAllByBusinessID( $business_id )
    {
        $sequenceMapper = new \Model\Mappers\SequenceMapper( $this->container );
        $sequences = $sequenceMapper->mapAllFromBusinessID( $business_id );

        return $sequences;
    }

    public function checkOut( $id )
    {
        $sequenceMapper = new \Model\Mappers\SequenceMapper( $this->container );
        $sequenceMapper->updateCheckedOutByID( 1, $id );
    }

    public function checkIn( $id )
    {
        $sequenceMapper = new \Model\Mappers\SequenceMapper( $this->container );
        $sequenceMapper->updateCheckedOutByID( 0, $id );
    }
}
