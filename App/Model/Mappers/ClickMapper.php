<?php

namespace Model\Mappers;

class ClickMapper extends DataMapper
{
    public function create( \Model\Click $click )
    {
        $id = $this->insert(
            "click",
            [ "business_id", "ip", "property", "property_sub_type", "timestamp" ],
            [ $click->business_id, $click->ip, $click->property, $click->property_sub_type, $click->timestamp ]
        );

        $click->id = $id;

        return $click;
    }

    public function mapAll()
    {
        $clicks = [];
        $sql = $this->DB->prepare( "SELECT * FROM click" );
        $sql->execute();
        while ( $resp = $sql->fetch( \PDO::FETCH_ASSOC ) ) {
            $click = $this->entityFactory->build( "Click" );
            $this->populate( $click, $resp );
            $clicks[] = $click;
        }

        return $clicks;
    }

    public function mapFromID( \Model\Click $click, $id )
    {
        $sql = $this->DB->prepare( "SELECT * FROM click WHERE id = :id" );
        $sql->bindParam( ":id", $id );
        $sql->execute();
        $resp = $sql->fetch( \PDO::FETCH_ASSOC );
        $this->populate( $click, $resp );
        return $click;
    }

    public function mapAllFromBusinessID( $business_id )
    {
        $clicks = [];
        $sql = $this->DB->prepare( "SELECT * FROM click WHERE business_id = :business_id" );
        $sql->bindParam( ":business_id", $business_id );
        $sql->execute();
        while ( $resp = $sql->fetch( \PDO::FETCH_ASSOC ) ) {
            $click = $this->entityFactory->build( "Click" );
            $this->populate( $click, $resp );
            $clicks[] = $click;
        }

        return $clicks;
    }

    public function mapAllFromBusinessIDAndProperty( $business_id, $property )
    {
        $clicks = [];
        $sql = $this->DB->prepare( "SELECT * FROM click WHERE business_id = :business_id AND property = :property" );
        $sql->bindParam( ":business_id", $business_id );
        $sql->bindParam( ":property", $property );
        $sql->execute();
        while ( $resp = $sql->fetch( \PDO::FETCH_ASSOC ) ) {
            $click = $this->entityFactory->build( "Click" );
            $this->populate( $click, $resp );
            $clicks[] = $click;
        }

        return $clicks;
    }

    public function mapAllFromBusinessIDAndPropertyAndSubType( $business_id, $property, $property_sub_type )
    {
        $clicks = [];
        $sql = $this->DB->prepare( "SELECT * FROM click WHERE business_id = :business_id AND property = :property AND property_sub_type = :property_sub_type" );
        $sql->bindParam( ":business_id", $business_id );
        $sql->bindParam( ":property", $property );
        $sql->bindParam( ":property_sub_type", $property_sub_type );
        $sql->execute();
        while ( $resp = $sql->fetch( \PDO::FETCH_ASSOC ) ) {
            $click = $this->entityFactory->build( "Click" );
            $this->populate( $click, $resp );
            $clicks[] = $click;
        }

        return $clicks;
    }
}
