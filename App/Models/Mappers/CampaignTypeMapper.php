<?php

namespace Model\Mappers;

class CampaignTypeMapper extends DataMapper
{

  public function mapAll()
  {
    $entityFactory = $this->container->getService( "entity-factory" );
    $campaignTypes = [];
    $sql = $this->DB->prepare( "SELECT * FROM campaign_type" );
    $sql->execute();
    while ( $resp = $sql->fetch( \PDO::FETCH_ASSOC ) ) {
      $campaignType = $entityFactory->build( "CampaignType" );
      $this->populateCampaignType( $campaignType, $resp );
      $campaignTypes[] = $campaignType;
    }

    return $campaignTypes;
  }

  public function mapFromID( \Model\CampaignType $campaignType, $id )
  {
    $sql = $this->DB->prepare( "SELECT * FROM campaign_type WHERE id = :id" );
    $sql->bindParam( ":id", $id );
    $sql->execute();
    $resp = $sql->fetch( \PDO::FETCH_ASSOC );
    $this->populateCampaignType( $campaignType, $resp );
    return $campaignType;
  }

  private function populateCampaignType( \Model\CampaignType $campaignType, $data )
  {
    $campaignType->id                = $data[ "id" ];
    $campaignType->name              = $data[ "name" ];
    $campaignType->description       = $data[ "description" ];
    $campaignType->logo_filename     = $data[ "logo_filename" ];
  }

}
