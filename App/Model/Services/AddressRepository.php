<?php

namespace Model\Services;

class AddressRepository extends Repository
{

  public function getAll()
  {
    $mapper = $this->getMapper();
    $addresss = $mapper->mapAll();
    return $addresss;
  }

  public function getByID( $id )
  {
    $mapper = $this->getMapper();
    $address = $mapper->build( $this->entityName );
    $mapper->mapFromID( $address, $id );

    return $address;
  }

}
