<?php

namespace Model\Services;

class PhoneRepository extends Service
{

    public function create( $country_code, $national_number )
    {
        $phone = new \Model\Phone();
        $phoneMapper = new \Model\Mappers\PhoneMapper( $this->container );
        $phone->country_code = trim( preg_replace( "/[^0-9]/", "", $country_code ) );
        $phone->national_number = trim( preg_replace( "/[^0-9]/", "", $national_number ) );
        $phoneMapper->create( $phone );

        return $phone;
    }

    public function updateByID( \Model\Phone $phone, $id )
    {
        $phoneMapper = new \Model\Mappers\PhoneMapper( $this->container );
        $phoneMapper->updateByID( $phone, $id );
    }

    public function getAll()
    {
        $phoneMapper = new \Model\Mappers\PhoneMapper( $this->container );
        $phones = $phoneMapper->mapAll();
        return $phones;
    }

    public function getByID( $id )
    {
        $phone = new \Model\Phone();
        $phoneMapper = new \Model\Mappers\PhoneMapper( $this->container );
        $phoneMapper->mapFromID( $phone, $id );

        return $phone;
    }

}
