<?php

namespace Model\Services;

class SequenceRepository extends Repository
{
    public function getAllAvailableForCheckout()
    {
        $mapper = $this->getMapper();
        $sequences = $mapper->mapAllFromCheckedOut();

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
