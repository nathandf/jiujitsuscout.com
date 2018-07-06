<?php

namespace Models\Mappers;

class CurrencyMapper extends DataMapper
{

    public function mapAll()
    {
        $entityFactory = $this->container->getService( "entity-factory" );
        $currencies = [];
        $sql = $this->DB->prepare( "SELECT * FROM currency" );
        $sql->execute();
        while ( $resp = $sql->fetch( \PDO::FETCH_ASSOC ) ) {
            $currency = $entityFactory->build( "Currency" );
            $this->populateCurrency( $currency, $resp );
            $currencies[] = $currency;
        }

        return $currencies;
    }

    public function mapFromCountry( $country )
    {
        $country = strtolower( $country );
        $entityFactory = $this->container->getService( "entity-factory" );

        $sql = $this->DB->prepare( "SELECT * FROM currency WHERE country = :country" );
        $sql->bindParam( ":country", $country );
        $sql->execute();
        $resp = $sql->fetch( \PDO::FETCH_ASSOC );
        $currency = $entityFactory->build( "Currency" );
        $this->populateCurrency( $currency, $resp );

        return $currency;
    }

    public function populateCurrency( $currency, $data )
    {
        $currency->country          = $data[ "country" ];
        $currency->currency         = $data[ "currency" ];
        $currency->code             = $data[ "code" ];
        $currency->symbol           = $data[ "symbol" ];
    }

}
