<?php

namespace Model\Mappers;

use Model\ProspectPurchase;

class ProspectPurchaseMapper extends DataMapper
{

    public function create( \Model\ProspectPurchase $prospectPurchase )
    {
        $id = $this->insert(
            "prospect_purchase",
            [ "business_id", "prospect_id" ],
            [ $prospectPurchase->business_id, $prospectPurchase->prospect_id ]
        );
        $prospectPurchase->id = $id;

        return $prospectPurchase;
    }

    public function mapFromID( ProspectPurchase $prospectPurchase, $id )
    {
        $sql = $this->DB->prepare( 'SELECT * FROM prospect_purchase WHERE id = :id' );
        $sql->bindParam( ":id", $id );
        $sql->execute();
        $resp = $sql->fetch( \PDO::FETCH_ASSOC );
        $this->populateProspectPurchase( $prospectPurchase, $resp );

        return $prospectPurchase;
    }

    public function mapFromProspectID( ProspectPurchase $prospectPurchase, $prospect_id )
    {
        $sql = $this->DB->prepare( 'SELECT * FROM prospect_purchase WHERE prospect_id = :prospect_id' );
        $sql->bindParam( ":prospect_id", $prospect_id );
        $sql->execute();
        $resp = $sql->fetch( \PDO::FETCH_ASSOC );
        $this->populateProspectPurchase( $prospectPurchase, $resp );

        return $prospectPurchase;
    }

    public function mapAll()
    {
        $entityFactory = $this->container->getService( "entity-factory" );
        $prospectPurchases = [];
        $sql = $this->DB->prepare( "SELECT * FROM prospect_purchase" );
        $sql->execute();

        while ( $resp = $sql->fetch( \PDO::FETCH_ASSOC ) ) {
            $prospectPurchase = $entityFactory->build( "ProspectPurchase" );
            $this->populateProspectPurchase( $prospectPurchase, $resp );
            $prospectPurchases[] = $prospectPurchase;
        }

        return $prospectPurchases;
    }

    public function mapAllFromBusinessID( $business_id )
    {
        $entityFactory = $this->container->getService( "entity-factory" );
        $prospectPurchases = [];
        $sql = $this->DB->prepare( "SELECT * FROM prospect_purchase WHERE business_id = :business_id" );
        $sql->bindParam( ":business_id", $business_id );
        $sql->execute();

        while ( $resp = $sql->fetch( \PDO::FETCH_ASSOC ) ) {
            $prospectPurchase = $entityFactory->build( "ProspectPurchase" );
            $this->populateProspectPurchase( $prospectPurchase, $resp );
            $prospectPurchases[] = $prospectPurchase;
        }

        return $prospectPurchases;
    }

    private function populateProspectPurchase( \Model\ProspectPurchase $prospectPurchase, $data )
    {
        $prospectPurchase->id = $data[ "id" ];
        $prospectPurchase->business_id = $data[ "business_id" ];
        $prospectPurchase->prospect_id = $data[ "prospect_id" ];
    }

}
