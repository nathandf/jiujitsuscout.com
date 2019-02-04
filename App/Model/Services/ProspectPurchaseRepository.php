<?php

namespace Model\Services;

class ProspectPurchaseRepository extends Repository
{
    public function create( $business_id, $prospect_id )
    {
        $mapper = $this->getMapper();
        $prospectPurchase = $mapper->build( $this->entityName );
        $prospectPurchase->business_id = $business_id;
        $prospectPurchase->prospect_id = $prospect_id;
        $mapper->create( $prospectPurchase );

        return $prospectPurchase;
    }

    public function getAll()
    {
        $mapper = $this->getMapper();
        $prospectPurchases = $mapper->mapAll();

        return $prospectPurchases;
    }

    public function getAllByBusinessID( $business_id )
    {
        $mapper = $this->getMapper();
        $prospectPurchases = $mapper->mapAllFromBusinessID( $business_id );

        return $prospectPurchases;
    }

    public function getByID( $id )
    {
        $mapper = $this->getMapper();
        $prospectPurchase = $mapper->build( $this->entityName );
        $prospectPurchases = $mapper->mapFromID( $prospectPurchase, $id );

        return $prospectPurchase;
    }

    public function getByProspectID( $prospect_id )
    {
        $mapper = $this->getMapper();
        $prospectPurchase = $mapper->build( $this->entityName );
        $prospectPurchases = $mapper->mapFromProspectID( $prospectPurchase, $prospect_id );

        return $prospectPurchases;
    }
}
