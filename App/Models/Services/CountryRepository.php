<?php

namespace Model\Services;

class CountryRepository extends Service
{

  public function getAll()
  {
    $countryMapper = new \Model\Mappers\CountryMapper( $this->container );
    $countries = $countryMapper->mapAll();
    return $countries;
  }

  public function getByISO( $iso )
  {
    $countryMapper = new \Model\Mappers\CountryMapper( $this->container );
    $country = $countryMapper->mapFromISO( $iso );
    return $country;
  }

  public function getByName( $name )
  {
    $countryMapper = new \Model\Mappers\CountryMapper( $this->container );
    $country = $countryMapper->mapFromName( $name );
    return $country;
  }

}
