<?php

namespace Model\Mappers;

class AddressMapper extends DataMapper
{
    public function mapAll()
    {
        $addresss = [];
        $sql = $this->DB->prepare( "SELECT * FROM address" );
        $sql->execute();

        while ( $resp = $sql->fetch( \PDO::FETCH_ASSOC ) ) {
            $address = $this->entityFactory->build( "Address" );
            $this->populate( $address, $resp );
            $addresss[] = $address;
        }

        return $addresss;
    }

    public function mapFromID( \Model\Address $address, $id )
    {
        $sql = $this->DB->prepare( "SELECT * FROM address WHERE id = :id" );
        $sql->bindParam( ":id", $id );
        $sql->execute();
        $resp = $sql->fetch( \PDO::FETCH_ASSOC );
        $this->populate( $address, $resp );

        return $address;
    }
}
