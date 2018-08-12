<?php

namespace Model;

class Phone
{

  public $id;
  public $country_code;
  public $national_number;

  public function getPhoneNumber()
  {
    return $this->getCountryCode() . $this->getNationalNumber();
  }

  public function setCountryCode( $country_code )
  {
    $this->country_code = preg_replace("/[^0-9]/", "", $country_code );
  }

  public function getCountryCode()
  {
    if ( isset( $this->country_code ) ) {
      return $this->country_code;
    }
  }

  public function setNationalNumber( $national_number )
  {
    $this->national_number = preg_replace("/[^0-9]/", "", $national_number );
  }

  public function getNationalNumber()
  {
    if ( isset( $this->national_number ) ) {
      return $this->national_number;
    }
  }

}
