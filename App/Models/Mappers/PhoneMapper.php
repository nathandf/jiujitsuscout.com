<?php

namespace Model\Mappers;

class PhoneMapper extends DataMapper
{

    public function create( \Model\Phone $phone )
    {
        if ( isset( $phone->country_code ) === false || $phone->country_code == "" ) {
            $phone->country_code = null;
        }
        if ( isset( $phone->national_number ) === false || $phone->national_number == "" ) {
            $phone->national_number = null;
        }

        $id = $this->insert(
            "phone",
            [ "country_code", "national_number" ],
            [ $phone->country_code, $phone->national_number ]
        );

        $phone->id = $id;

        return $phone;
    }

    public function updateByID( \Model\Phone $phone, $id )
    {
        if ( isset( $phone->country_code ) === false || $phone->country_code == "") {
            $phone->country_code = null;
        }
        if ( isset( $phone->national_number ) === false|| $phone->national_number == "" ) {
            $phone->national_number = null;
        }
        $this->update( "phone", "country_code", $phone->country_code, "id", $id );
        $this->update( "phone", "national_number", $phone->national_number, "id", $id );
    }

    public function mapAll()
    {
        $entityFactory = $this->container->getService( "entity-factory" );
        $phones = [];
        $sql = $this->DB->prepare( "SELECT * FROM phone" );
        $sql->execute();
        while ( $resp = $sql->fetch( \PDO::FETCH_ASSOC ) ) {
            $phone = $entityFactory->build( "Phone" );
            $this->populatePhone( $phone, $resp );
            $phones[] = $phone;
        }

        return $phones;
    }

    public function mapFromID( \Model\Phone $phone, $id )
    {
        $sql = $this->DB->prepare( "SELECT * FROM phone WHERE id = :id" );
        $sql->bindParam( ":id", $id );
        $sql->execute();
        $resp = $sql->fetch( \PDO::FETCH_ASSOC );
        $this->populatePhone( $phone, $resp );
        return $phone;
    }

    private function populatePhone( \Model\Phone $phone, $data )
    {
        $phone->id                = $data[ "id" ];
        $phone->setCountryCode( $data[ "country_code" ] );
        $phone->setNationalNumber( $data[ "national_number" ] );
    }

}
