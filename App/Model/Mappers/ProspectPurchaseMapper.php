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
        $this->populate( $prospectPurchase, $resp );

        return $prospectPurchase;
    }

    public function mapFromProspectID( ProspectPurchase $prospectPurchase, $prospect_id )
    {
        $sql = $this->DB->prepare( 'SELECT * FROM prospect_purchase WHERE prospect_id = :prospect_id' );
        $sql->bindParam( ":prospect_id", $prospect_id );
        $sql->execute();
        $resp = $sql->fetch( \PDO::FETCH_ASSOC );
        $this->populate( $prospectPurchase, $resp );

        return $prospectPurchase;
    }

    public function mapAll()
    {

        $prospectPurchases = [];
        $sql = $this->DB->prepare( "SELECT * FROM prospect_purchase" );
        $sql->execute();

        while ( $resp = $sql->fetch( \PDO::FETCH_ASSOC ) ) {
            $prospectPurchase = $this->entityFactory->build( "ProspectPurchase" );
            $this->populate( $prospectPurchase, $resp );
            $prospectPurchases[] = $prospectPurchase;
        }

        return $prospectPurchases;
    }

    public function mapAllFromBusinessID( $business_id )
    {

        $prospectPurchases = [];
        $sql = $this->DB->prepare( "SELECT * FROM prospect_purchase WHERE business_id = :business_id" );
        $sql->bindParam( ":business_id", $business_id );
        $sql->execute();

        while ( $resp = $sql->fetch( \PDO::FETCH_ASSOC ) ) {
            $prospectPurchase = $this->entityFactory->build( "ProspectPurchase" );
            $this->populate( $prospectPurchase, $resp );
            $prospectPurchases[] = $prospectPurchase;
        }

        return $prospectPurchases;
    }
}
