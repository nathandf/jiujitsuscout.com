<?php

namespace Models\Services;

class CampaignRepository extends Service
{

  public function create( $account_id, $business_id, $campaign_type_id, $status, $name, $description, $start_date, $end_date, $recur_date )
  {
    $campaign = new \Models\Campaign();
    $campaignMapper = new \Models\Mappers\CampaignMapper( $this->container );
    $campaign->account_id = $account_id;
    $campaign->business_id = $business_id;
    $campaign->campaign_type_id = $campaign_type_id;
    $campaign->status = $status;
    $campaign->name = $name;
    $campaign->description = $description;
    $campaign->start_date = $start_date;
    $campaign->end_date = $end_date;
    $campaign->recur_date = $recur_date;
    $campaignMapper->create( $campaign );

    return $campaign;
  }

  public function getByBusinessID( $id )
  {
    $campaign = new \Models\Campaign();
    $campaignMapper = new \Models\Mappers\CampaignMapper( $this->container );
    $campaignMapper->mapFromBusinessID( $campaign, $id );
    return $campaign;
  }

  public function getByID( $id )
  {
    $campaign = new \Models\Campaign();
    $campaignMapper = new \Models\Mappers\CampaignMapper( $this->container );
    $campaignMapper->mapFromID( $campaign, $id );
    return $campaign;
  }

  public function getAllByBusinessID( $business_id )
  {
    $campaignMapper = new \Models\Mappers\CampaignMapper( $this->container );
    $campaigns = $campaignMapper->mapAllFromBusinessID( $business_id );

    return $campaigns;
  }

}
