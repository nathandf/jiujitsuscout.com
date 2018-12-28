<?php

namespace Model\Mappers;

use Model\Campaign;

class CampaignMapper extends DataMapper
{

  public function create( \Model\Campaign $campaign )
  {
    $id = $this->insert(
                    "campaign",
                    [ "account_id", "business_id", "campaign_type_id", "status", "name", "description", "start_date", "end_date", "recur_date" ],
                    [ $campaign->account_id, $campaign->business_id, $campaign->campaign_type_id, $campaign->status, $campaign->name, $campaign->description, $campaign->start_date, $campaign->end_date, $campaign->recur_date ]
                  );
    $campaign->id = $id;
    return $campaign;
  }

  public function mapFromID( Campaign $campaign, $id )
  {
    $sql = $this->DB->prepare( "SELECT * FROM campaign WHERE id = :id" );
    $sql->bindParam( ":id", $id );
    $sql->execute();
    $resp = $sql->fetch( \PDO::FETCH_ASSOC );
    $this->populateCampaign( $campaign, $resp );
    return $campaign;
  }

  public function mapAllFromBusinessID( $business_id )
  {
    
    $campaigns = [];
    $sql = $this->DB->prepare( "SELECT * FROM campaign WHERE business_id = :business_id" );
    $sql->bindParam( ":business_id", $business_id );
    $sql->execute();
    while ( $resp = $sql->fetch( \PDO::FETCH_ASSOC ) ) {
      $campaign = $this->entityFactory->build( "Campaign" );
      $this->populateCampaign( $campaign, $resp );

      $campaigns[] = $campaign;
    }

    return $campaigns;
  }

  public function updateDescriptionByID( $id, $description )
  {
    $this->update( "campaign", "description", $description, "id", $id );
  }

  public function updateNameByID( $id, $name )
  {
    $this->update( "campaign", "name", $name, "id", $id );
  }

  public function updateStartDateByID( $id, $start_date )
  {
    $this->update( "campaign", "start_date", $start_date, "id", $id );
  }

  public function updateEndDateByID( $id, $end_date )
  {
    $this->update( "campaign", "end_date", $end_date, "id", $id );
  }

  public function updateRecurDateByID( $id, $recur_date )
  {
    $this->update( "campaign", "recur_date", $recur_date, "id", $id );
  }

  public function populateCampaign( $campaign, $data )
  {
    $campaign->id                          = $data[ "id" ];
    $campaign->account_id                  = $data[ "account_id" ];
    $campaign->business_id                 = $data[ "business_id" ];
    $campaign->campaign_type_id            = $data[ "campaign_type_id" ];
    $campaign->status                      = $data[ "status" ];
    $campaign->name                        = $data[ "name" ];
    $campaign->description                 = $data[ "description" ];
    $campaign->start_date                  = $data[ "start_date" ];
    $campaign->end_date                    = $data[ "end_date" ];
    $campaign->recur_date                  = $data[ "recur_date" ];
  }

}
