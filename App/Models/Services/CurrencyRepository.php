<?php

namespace Models\Services;

class CurrencyRepository extends Service
{

    public function getAll()
    {
        $currencyMapper = new \Models\Mappers\CurrencyMapper( $this->container );
        $currencies = $currencyMapper->mapAll();

        return $currencies;
    }

    public function getByCountry( $country )
    {
        $currencyMapper = new \Models\Mappers\CurrencyMapper( $this->container );
        $currency = $currencyMapper->mapFromCountry( $country );

        return $currency;
    }

    public function getByName( $name )
    {
        $currencyMapper = new \Models\Mappers\CurrencyMapper( $this->container );
        $currency = $currencyMapper->mapFromName( $name );

        return $currency;
    }

}
