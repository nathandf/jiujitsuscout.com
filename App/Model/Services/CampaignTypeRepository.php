<?php

namespace Model\Services;

class CampaignTypeRepository extends Repository
{
    public function getAll()
    {
        $mapper = $this->getMapper();
        $campaignTypes = $mapper->mapAll();

        return $campaignTypes;
    }

    public function getByID( $id )
    {
        $mapper = $this->getMapper();
        $campaignType = $mapper->build( $this->entityName );
        $mapper->mapFromID( $campaignType, $id );

        return $campaignType;
    }
}
