<?php

namespace Model\Mappers;

class CountryMapper extends DataMapper
{
    public function mapAll()
    {
        $countries = [];
        $sql = $this->DB->prepare( "SELECT * FROM country" );
        $sql->execute();

        while ( $resp = $sql->fetch( \PDO::FETCH_ASSOC ) ) {
            $country = $this->entityFactory->build( "Country" );
            $this->populate( $country, $resp );
            $countries[] = $country;
        }
        return $countries;
    }

    public function mapFromISO( $iso )
    {
        $sql = $this->DB->prepare( "SELECT * FROM country WHERE iso = :iso" );
        $sql->bindParam( ":iso", $iso );
        $sql->execute();
        $resp = $sql->fetch( \PDO::FETCH_ASSOC );
        $country = $this->entityFactory->build( "Country" );
        $this->populate( $country, $resp );

        return $country;
    }

    public function mapFromName( $name )
    {
        $sql = $this->DB->prepare( "SELECT * FROM country WHERE name = :name" );
        $sql->bindParam( ":name", strtoupper( $name ) );
        $sql->execute();
        $resp = $sql->fetch( \PDO::FETCH_ASSOC );
        $country = $this->entityFactory->build( "Country" );
        $this->populate( $country, $resp );

        return $country;
    }
}
