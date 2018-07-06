<?php

namespace Models\Services;

class CampaignTypeRepository extends Service
{

  public function getAll()
  {
    $campaignTypeMapper = new \Models\Mappers\CampaignTypeMapper( $this->container );
    $campaignTypes = $campaignTypeMapper->mapAll();
    return $campaignTypes;
  }

  public function getByID( $id )
  {
    $campaignType = new \Models\CampaignType();
    $campaignTypeMapper = new \Models\Mappers\CampaignTypeMapper( $this->container );
    $campaignTypeMapper->mapFromID( $campaignType, $id );

    return $campaignType;
  }

}
