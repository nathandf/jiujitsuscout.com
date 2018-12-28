<?php

namespace Model\Services;

class CountryRepository extends Repository
{
    public function getAll()
    {
        $mapper = $this->getMapper();
        $countries = $mapper->mapAll();

        return $countries;
    }

    public function getByISO( $iso )
    {
        $mapper = $this->getMapper();
        $country = $mapper->mapFromISO( $iso );

        return $country;
    }

    public function getByName( $name )
    {
        $mapper = $this->getMapper();
        $country = $mapper->mapFromName( $name );

        return $country;
    }
}
