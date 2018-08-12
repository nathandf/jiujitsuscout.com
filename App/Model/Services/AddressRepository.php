<?php

namespace Model\Services;

class AddressRepository extends Service
{

  public function getAll()
  {
    $addressMapper = new \Model\Mappers\AddressMapper( $this->container );
    $addresss = $addressMapper->mapAll();
    return $addresss;
  }

  public function getByID( $id )
  {
    $address = new \Model\Address();
    $addressMapper = new \Model\Mappers\AddressMapper( $this->container );
    $addressMapper->mapFromID( $address, $id );

    return $address;
  }

}
