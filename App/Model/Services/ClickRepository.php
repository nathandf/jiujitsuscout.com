<?php

namespace Model\Services;

class ClickRepository extends Service
{

    public function create( $business_id, $ip, $property, $property_sub_type = null )
    {
        $click = new \Model\Click();
        $click->business_id = $business_id;
        $click->ip = $ip;
        $click->property = $property;
        $click->property_sub_type = $property_sub_type;
        $click->timestamp = time();
        $clickMapper = new \Model\Mappers\ClickMapper( $this->container );
        $clickMapper->create( $click );

        return $click;
    }

    public function getAll()
    {
        $clickMapper = new \Model\Mappers\ClickMapper( $this->container );
        $clicks = $clickMapper->mapAll();
        return $clicks;
    }

    public function getByID( $id )
    {
        $click = new \Model\Click();
        $clickMapper = new \Model\Mappers\ClickMapper( $this->container );
        $clickMapper->mapFromID( $click, $id );

        return $click;
    }

    public function getByAllBusinessID( $business_id )
    {
        $clickMapper = new \Model\Mappers\ClickMapper( $this->container );
        $clicks = $clickMapper->mapAllFromBusienssID( $business_id );

        return $click;
    }

    public function getAllByBusinessIDAndProperty( $business_id, $property )
    {
        $clickMapper = new \Model\Mappers\ClickMapper( $this->container );
        $clicks = $clickMapper->mapAllFromBusinessIDAndProperty( $business_id, $property );

        return $clicks;
    }

    public function getAllByBusinessIDAndPropertyAndSubType( $business_id, $property, $property_sub_type )
    {
        $clickMapper = new \Model\Mappers\ClickMapper( $this->container );
        $clicks = $clickMapper->mapAllFromBusinessIDAndPropertyAndSubType( $business_id, $property, $property_sub_type );

        return $clicks;
    }

}
