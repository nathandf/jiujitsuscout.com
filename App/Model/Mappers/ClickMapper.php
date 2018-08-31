<?php

namespace Model\Mappers;

class ClickMapper extends DataMapper
{

    public function create( \Model\Click $click )
    {
        $id = $this->insert(
            "click",
            [ "business_id", "ip", "property", "timestamp" ],
            [ $click->business_id, $click->ip, $click->property, $click->timestamp ]
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

    public function mapFromBusinessID( \Model\Click $click, $business_id )
    {
        $sql = $this->DB->prepare( "SELECT * FROM click WHERE business_id = :business_id" );
        $sql->bindParam( ":business_id", $business_id );
        $sql->execute();
        $resp = $sql->fetch( \PDO::FETCH_ASSOC );
        $this->populateClick( $click, $resp );
        return $click;
    }

    public function mapFromBusinessIDAndProperty( \Model\Click $click, $business_id, $property )
    {
        $sql = $this->DB->prepare( "SELECT * FROM click WHERE business_id = :business_id AND property = :property" );
        $sql->bindParam( ":business_id", $business_id );
        $sql->bindParam( ":property", $property );
        $sql->execute();
        $resp = $sql->fetch( \PDO::FETCH_ASSOC );
        $this->populateClick( $click, $resp );
        return $click;
    }

    private function populateClick( \Model\Click $click, $data )
    {
        $click->id = $data[ "id" ];
        $click->business_id = $data[ "business_id" ];
        $click->ip = $data[ "ip" ];
        $click->property = $data[ "property" ];
        $click->timestamp = $data[ "timepstamp" ];
    }

}
