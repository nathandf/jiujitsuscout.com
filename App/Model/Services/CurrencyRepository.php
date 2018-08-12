<?php

namespace Model\Services;

class CurrencyRepository extends Service
{

    public function getAll()
    {
        $currencyMapper = new \Model\Mappers\CurrencyMapper( $this->container );
        $currencies = $currencyMapper->mapAll();

        return $currencies;
    }

    public function getByCountry( $country )
    {
        $currencyMapper = new \Model\Mappers\CurrencyMapper( $this->container );
        $currency = $currencyMapper->mapFromCountry( $country );

        return $currency;
    }

    public function getByCode( $code )
    {
        $currencyMapper = new \Model\Mappers\CurrencyMapper( $this->container );
        $currency = $currencyMapper->mapFromCode( $code );

        return $currency;
    }

    public function getByName( $name )
    {
        $currencyMapper = new \Model\Mappers\CurrencyMapper( $this->container );
        $currency = $currencyMapper->mapFromName( $name );

        return $currency;
    }

}
