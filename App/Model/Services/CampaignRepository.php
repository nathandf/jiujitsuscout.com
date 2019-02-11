<?php

namespace Model\Services;

class CampaignRepository extends Repository
{

    public function create( $account_id, $business_id, $campaign_type_id, $status, $name, $description, $start_date, $end_date, $recur_date )
    {
        $mapper = $this->getMapper();
        $campaign = $mapper->build( $this->entityName );
        $campaign->account_id = $account_id;
        $campaign->business_id = $business_id;
        $campaign->campaign_type_id = $campaign_type_id;
        $campaign->status = $status;
        $campaign->name = $name;
        $campaign->description = $description;
        $campaign->start_date = $start_date;
        $campaign->end_date = $end_date;
        $campaign->recur_date = $recur_date;
        $mapper->create( $campaign );

        return $campaign;
    }

    public function getByBusinessID( $id )
    {
        $mapper = $this->getMapper();
        $campaign = $mapper->build( $this->entityName );
        $mapper->mapFromBusinessID( $campaign, $id );

        return $campaign;
    }

    public function getByID( $id )
    {
        $mapper = $this->getMapper();
        $campaign = $mapper->build( $this->entityName );
        $mapper->mapFromID( $campaign, $id );

        return $campaign;
    }

    public function getAllByBusinessID( $business_id )
    {
        $mapper = $this->getMapper();
        $campaigns = $mapper->mapAllFromBusinessID( $business_id );

        return $campaigns;
    }

}
