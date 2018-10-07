<?php

namespace Model\Services;

class ProspectPurchaseRepository extends Service
{
    public function create( $business_id, $prospect_id )
    {
        $prospectPurchase = new \Model\ProspectPurchase();
        $prospectPurchaseMapper = new \Model\Mappers\ProspectPurchaseMapper( $this->container );
        $prospectPurchase->business_id = $business_id;
        $prospectPurchase->prospect_id = $prospect_id;
        $prospectPurchaseMapper->create( $prospectPurchase );

        return $prospectPurchase;
    }

    public function getAll()
    {
        $prospectPurchaseMapper = new \Model\Mappers\ProspectPurchaseMapper( $this->container );
        $prospectPurchases = $prospectPurchaseMapper->mapAll();

        return $prospectPurchases;
    }

    public function getAllByBusinessID( $business_id )
    {
        $prospectPurchaseMapper = new \Model\Mappers\ProspectPurchaseMapper( $this->container );
        $prospectPurchases = $prospectPurchaseMapper->mapAllFromBusinessID( $business_id );

        return $prospectPurchases;
    }

    public function getByID( $id )
    {
        $prospectPurchase = new \Model\ProspectPurchase();
        $prospectPurchaseMapper = new \Model\Mappers\ProspectPurchaseMapper( $this->container );
        $prospectPurchases = $prospectPurchaseMapper->mapFromID( $prospectPurchase, $id );

        return $prospectPurchase;
    }

    public function getByProspectID( $prospect_id )
    {
        $prospectPurchase = new \Model\ProspectPurchase();
        $prospectPurchaseMapper = new \Model\Mappers\ProspectPurchaseMapper( $this->container );
        $prospectPurchases = $prospectPurchaseMapper->mapFromProspectID( $prospectPurchase, $prospect_id );

        return $prospectPurchases;
    }
}
