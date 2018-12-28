<?php

namespace Model\Mappers;

class AddressMapper extends DataMapper
{

  public function mapAll()
  {
    
    $addresss = [];
    $sql = $this->DB->prepare( "SELECT * FROM address" );
    $sql->execute();
    while ( $resp = $sql->fetch( \PDO::FETCH_ASSOC ) ) {
      $address = $this->entityFactory->build( "Address" );
      $this->populateAddress( $address, $resp );
      $addresss[] = $address;
    }

    return $addresss;
  }

  public function mapFromID( \Model\Address $address, $id )
  {
    $sql = $this->DB->prepare( "SELECT * FROM address WHERE id = :id" );
    $sql->bindParam( ":id", $id );
    $sql->execute();
    $resp = $sql->fetch( \PDO::FETCH_ASSOC );
    $this->populateAddress( $address, $resp );
    return $address;
  }

  private function populateAddress( \Model\Address $address, $data )
  {
    $address->id                = $data[ "id" ];
    $address->address_1         = $data[ "address_1" ];
    $address->address_2         = $data[ "address_2" ];
    $address->city              = $data[ "city" ];
    $address->region            = $data[ "region" ];
    $address->postal_code       = $data[ "postal_code" ];
    $address->country_id        = $data[ "country_id" ];
  }

}
