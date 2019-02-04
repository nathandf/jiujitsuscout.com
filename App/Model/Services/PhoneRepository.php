<?php

namespace Model\Services;

class PhoneRepository extends Repository
{
    public function create( $country_code, $national_number )
    {
        $mapper = $this->getMapper();
        $phone = $mapper->build( $this->entityName );
        $phone->country_code = trim( preg_replace( "/[^0-9]/", "", $country_code ) );
        $phone->national_number = trim( preg_replace( "/[^0-9]/", "", $national_number ) );
        $mapper->create( $phone );

        return $phone;
    }

    public function updateByID( \Model\Phone $phone, $id )
    {
        $mapper = $this->getMapper();
        $mapper->updateByID( $phone, $id );
    }

    public function getAll()
    {
        $mapper = $this->getMapper();
        $phones = $mapper->mapAll();
        return $phones;
    }

    public function getByID( $id )
    {
        $mapper = $this->getMapper();
        $phone = $mapper->build( $this->entityName );
        $mapper->mapFromID( $phone, $id );

        return $phone;
    }
}
