<?php

namespace Model;

class Identity
{

	public $first_name;
    public $last_name;
    public $email;
    public $phone_id;
	public $phone_number;
    public $address_id;
    public $address_1;
    public $address_2;
    public $city;
    public $region;
    public $postal_code;
    public $country;

	public function setFirstName( $first_name )
    {
        $name = explode( " ", $first_name, 2 );
        if ( count( $name ) > 1 ) {
            $this->first_name = $name[ 0 ];
            $this->setLastName( $name[ 1 ] );
        } else {
            $this->first_name = $first_name;
        }
    }

    public function setLastName( $last_name )
    {
        $this->last_name = $last_name;
    }

    public function setEmail( $email )
    {
        $this->email = $email;
    }

    public function setPhoneNumber( $country_code, $national_number )
    {
        if ( isset( $country_code, $national_number ) && !is_null( $country_code ) && !is_null( $national_number ) && $country_code != "" && $national_number != "" ) {
            $this->phone_number = "+" . $country_code . " " . $national_number;
        } else {
            $this->phone_number = null;
        }
    }

    public function setAddress1( $address )
    {
        $this->address_1 = $address;
    }

    public function setAddress2( $address )
    {
        $this->address_2 = $address;
    }

    public function setCity( $city )
    {
        $this->city = $city;
    }

    public function setRegion( $region )
    {
        $this->region = $region;
    }

    public function setPostalCode( $postal )
    {
        $this->postal_code = $postal_code;
    }

    public function setCountry( $country )
    {
        $this->country = $country;
    }

}
