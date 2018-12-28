<?php

namespace Model\Services;

class ClickRepository extends Repository
{

    public function create( $business_id, $ip, $property, $property_sub_type = null )
    {
        $mapper = $this->getMapper();
        $click = $mapper->build( $this->entityName );
        $click->business_id = $business_id;
        $click->ip = $ip;
        $click->property = $property;
        $click->property_sub_type = $property_sub_type;
        $click->timestamp = time();
        $mapper->create( $click );

        return $click;
    }

    public function getAll()
    {
        $mapper = $this->getMapper();
        $clicks = $mapper->mapAll();
        return $clicks;
    }

    public function getByID( $id )
    {
        $mapper = $this->getMapper();
        $click = $mapper->build( $this->entityName );
        $mapper->mapFromID( $click, $id );

        return $click;
    }

    public function getByAllBusinessID( $business_id )
    {
        $mapper = $this->getMapper();
        $clicks = $mapper->mapAllFromBusienssID( $business_id );

        return $click;
    }

    public function getAllByBusinessIDAndProperty( $business_id, $property )
    {
        $mapper = $this->getMapper();
        $clicks = $mapper->mapAllFromBusinessIDAndProperty( $business_id, $property );

        return $clicks;
    }

    public function getAllByBusinessIDAndPropertyAndSubType( $business_id, $property, $property_sub_type )
    {
        $mapper = $this->getMapper();
        $clicks = $mapper->mapAllFromBusinessIDAndPropertyAndSubType( $business_id, $property, $property_sub_type );

        return $clicks;
    }

}
