<?php

namespace Model\Services;

class CurrencyRepository extends Repository
{

    public function getAll()
    {
        $mapper = $this->getMapper();
        $currencies = $mapper->mapAll();

        return $currencies;
    }

    public function getByCountry( $country )
    {
        $mapper = $this->getMapper();
        $currency = $mapper->mapFromCountry( $country );

        return $currency;
    }

    public function getByCode( $code )
    {
        $mapper = $this->getMapper();
        $currency = $mapper->mapFromCode( $code );

        return $currency;
    }

    public function getByName( $name )
    {
        $mapper = $this->getMapper();
        $currency = $mapper->mapFromName( $name );

        return $currency;
    }

}
