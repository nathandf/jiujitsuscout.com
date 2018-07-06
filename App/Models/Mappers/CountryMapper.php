<?php

namespace Models\Mappers;

class CountryMapper extends DataMapper
{

  public function mapAll()
  {
    $entityFactory = $this->container->getService( "entity-factory" );
    $countries = [];
    $sql = $this->DB->prepare( "SELECT * FROM country" );
    $sql->execute();
    while ( $resp = $sql->fetch( \PDO::FETCH_ASSOC ) ) {
      $country = $entityFactory->build( "Country" );
      $this->populateCountry( $country, $resp );
      $countries[] = $country;
    }
    return $countries;
  }

  public function mapFromISO( $iso )
  {
    $entityFactory = $this->container->getService( "entity-factory" );

    $sql = $this->DB->prepare( "SELECT * FROM country WHERE iso = :iso" );
    $sql->bindParam( ":iso", $iso );
    $sql->execute();
    $resp = $sql->fetch( \PDO::FETCH_ASSOC );
    $country = $entityFactory->build( "Country" );
    $this->populateCountry( $country, $resp );

    return $country;
  }

  public function mapFromName( $name )
  {
    $entityFactory = $this->container->getService( "entity-factory" );

    $sql = $this->DB->prepare( "SELECT * FROM country WHERE name = :name" );
    $sql->bindParam( ":name", strtoupper( $name ) );
    $sql->execute();
    $resp = $sql->fetch( \PDO::FETCH_ASSOC );
    $country = $entityFactory->build( "Country" );
    $this->populateCountry( $country, $resp );
    return $country;
  }

    public function populateCountry( $country, $data )
    {
        $country->id               = $data[ "id" ];
        $country->name             = $data[ "name" ];
        $country->nice_name        = $data[ "nicename" ];
        $country->iso              = $data[ "iso" ];
        $country->iso3             = $data[ "iso3" ];
        $country->numcode          = $data[ "numcode" ];
        $country->phonecode        = $data[ "phonecode" ];
    }

}
