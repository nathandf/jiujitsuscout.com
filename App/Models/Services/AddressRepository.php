<?php

namespace Models\Services;

class AddressRepository extends Service
{

  public function getAll()
  {
    $addressMapper = new \Models\Mappers\AddressMapper( $this->container );
    $addresss = $addressMapper->mapAll();
    return $addresss;
  }

  public function getByID( $id )
  {
    $address = new \Models\Address();
    $addressMapper = new \Models\Mappers\AddressMapper( $this->container );
    $addressMapper->mapFromID( $address, $id );

    return $address;
  }

}
