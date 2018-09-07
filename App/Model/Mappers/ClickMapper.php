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
        $entityFactory = $this->container->getService( "entity-factory" );
        $clicks = [];
        $sql = $this->DB->prepare( "SELECT * FROM click" );
        $sql->execute();
        while ( $resp = $sql->fetch( \PDO::FETCH_ASSOC ) ) {
            $click = $entityFactory->build( "Click" );
            $this->populateClick( $click, $resp );
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
        $this->populateClick( $click, $resp );
        return $click;
    }

    public function mapAllFromBusinessID( $business_id )
    {
        $entityFactory = $this->container->getService( "entity-factory" );
        $clicks = [];
        $sql = $this->DB->prepare( "SELECT * FROM click WHERE business_id = :business_id" );
        $sql->bindParam( ":business_id", $business_id );
        $sql->execute();
        while ( $resp = $sql->fetch( \PDO::FETCH_ASSOC ) ) {
            $click = $entityFactory->build( "Click" );
            $this->populateClick( $click, $resp );
            $clicks[] = $click;
        }

        return $clicks;
    }

    public function mapAllFromBusinessIDAndProperty( $business_id, $property )
    {
        $entityFactory = $this->container->getService( "entity-factory" );
        $clicks = [];
        $sql = $this->DB->prepare( "SELECT * FROM click WHERE business_id = :business_id AND property = :property" );
        $sql->bindParam( ":business_id", $business_id );
        $sql->bindParam( ":property", $property );
        $sql->execute();
        while ( $resp = $sql->fetch( \PDO::FETCH_ASSOC ) ) {
            $click = $entityFactory->build( "Click" );
            $this->populateClick( $click, $resp );
            $clicks[] = $click;
        }

        return $clicks;
    }

    public function mapAllFromBusinessIDAndPropertyAndSubType( $business_id, $property, $property_sub_type )
    {
        $entityFactory = $this->container->getService( "entity-factory" );
        $clicks = [];
        $sql = $this->DB->prepare( "SELECT * FROM click WHERE business_id = :business_id AND property = :property AND property_sub_type = :property_sub_type" );
        $sql->bindParam( ":business_id", $business_id );
        $sql->bindParam( ":property", $property );
        $sql->bindParam( ":property_sub_type", $property_sub_type );
        $sql->execute();
        while ( $resp = $sql->fetch( \PDO::FETCH_ASSOC ) ) {
            $click = $entityFactory->build( "Click" );
            $this->populateClick( $click, $resp );
            $clicks[] = $click;
        }

        return $clicks;
    }

    private function populateClick( \Model\Click $click, $data )
    {
        $click->id = $data[ "id" ];
        $click->business_id = $data[ "business_id" ];
        $click->ip = $data[ "ip" ];
        $click->property = $data[ "property" ];
        $click->property_sub_type = $data[ "property_sub_type" ];
        $click->timestamp = $data[ "timestamp" ];
    }

}
