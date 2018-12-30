<?php

namespace Model\Mappers;

class CurrencyMapper extends DataMapper
{
    public function mapAll()
    {

        $currencies = [];
        $sql = $this->DB->prepare( "SELECT * FROM currency" );
        $sql->execute();
        while ( $resp = $sql->fetch( \PDO::FETCH_ASSOC ) ) {
            $currency = $this->entityFactory->build( "Currency" );
            $this->populate( $currency, $resp );
            $currencies[] = $currency;
        }

        return $currencies;
    }

    public function mapFromCountry( $country )
    {
        $country = strtolower( $country );


        $sql = $this->DB->prepare( "SELECT * FROM currency WHERE country = :country" );
        $sql->bindParam( ":country", $country );
        $sql->execute();
        $resp = $sql->fetch( \PDO::FETCH_ASSOC );
        $currency = $this->entityFactory->build( "Currency" );
        $this->populate( $currency, $resp );

        return $currency;
    }

    public function mapFromCode( $code )
    {


        $sql = $this->DB->prepare( "SELECT * FROM currency WHERE code = :code" );
        $sql->bindParam( ":code", $code );
        $sql->execute();
        $resp = $sql->fetch( \PDO::FETCH_ASSOC );
        $currency = $this->entityFactory->build( "Currency" );
        $this->populate( $currency, $resp );

        return $currency;
    }
}
