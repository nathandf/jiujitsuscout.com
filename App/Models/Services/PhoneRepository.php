<?php

namespace Models\Services;

class PhoneRepository extends Service
{

    public function create( $country_code, $national_number )
    {
        $phone = new \Models\Phone();
        $phoneMapper = new \Models\Mappers\PhoneMapper( $this->container );
        $phone->country_code = $country_code;
        $phone->national_number = $national_number;
        $phoneMapper->create( $phone );

        return $phone;
    }

    public function updateByID( \Models\Phone $phone, $id )
    {
        $phoneMapper = new \Models\Mappers\PhoneMapper( $this->container );
        $phoneMapper->updateByID( $phone, $id );
    }

    public function getAll()
    {
        $phoneMapper = new \Models\Mappers\PhoneMapper( $this->container );
        $phones = $phoneMapper->mapAll();
        return $phones;
    }

    public function getByID( $id )
    {
        $phone = new \Models\Phone();
        $phoneMapper = new \Models\Mappers\PhoneMapper( $this->container );
        $phoneMapper->mapFromID( $phone, $id );

        return $phone;
    }

}
