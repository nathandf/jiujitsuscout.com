<?php

namespace Model\Services;

class SequenceRepository extends Service
{

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
