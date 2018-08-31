<?php

namespace Model\Services;

class ClickRepository extends Service
{

    public function create( $business_id, $ip, $property, $timestamp )
    {
        $click = new \Model\Click();
        $click->business_id = $business_id;
        $click->ip = $ip;
        $click->property = $property;
        $click->timestamp = $timestamp;
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

    public function getByBusinessID( $busienss_id )
    {
        $click = new \Model\Click();
        $clickMapper = new \Model\Mappers\ClickMapper( $this->container );
        $clickMapper->mapFromBusienssID( $click, $busienss_id );

        return $click;
    }

    public function getByBusinessIDAndProperty( $busienss_id, $property )
    {
        $click = new \Model\Click();
        $clickMapper = new \Model\Mappers\ClickMapper( $this->container );
        $clickMapper->mapFromBusinessIDAndProperty( $click, $busienss_id, $property );

        return $click;
    }

}
