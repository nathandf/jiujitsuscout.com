<?php

namespace Model\Services;

class CampaignTypeRepository extends Service
{

  public function getAll()
  {
    $campaignTypeMapper = new \Model\Mappers\CampaignTypeMapper( $this->container );
    $campaignTypes = $campaignTypeMapper->mapAll();
    return $campaignTypes;
  }

  public function getByID( $id )
  {
    $campaignType = new \Model\CampaignType();
    $campaignTypeMapper = new \Model\Mappers\CampaignTypeMapper( $this->container );
    $campaignTypeMapper->mapFromID( $campaignType, $id );

    return $campaignType;
  }

}
