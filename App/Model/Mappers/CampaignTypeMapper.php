<?php

namespace Model\Mappers;

class CampaignTypeMapper extends DataMapper
{
    public function mapAll()
    {
        $campaignTypes = [];
        $sql = $this->DB->prepare( "SELECT * FROM campaign_type" );
        $sql->execute();
        
        while ( $resp = $sql->fetch( \PDO::FETCH_ASSOC ) ) {
            $campaignType = $this->entityFactory->build( "CampaignType" );
            $this->populate( $campaignType, $resp );
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
        $this->populate( $campaignType, $resp );

        return $campaignType;
    }
}
