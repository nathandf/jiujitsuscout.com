<?php

namespace Models\Services;

class ResultRepository extends Service
{

    public function create( $search_id, $business_ids )
    {
        $result = new \Models\Result;
        $resultMapper = new \Models\Mappers\ResultMapper( $this->container );
        $result->search_id = $search_id;
        $result->business_ids = $business_ids;
        $resultMapper->create( $result );

        return $result;
    }

    public function getByID( $id )
    {
        $result = new \Models\Result;
        $resultMapper = new \Models\Mappers\ResultMapper( $this->container );
        $resultMapper->mapFromID( $result, $id );

        return $result;
    }

    public function getBySearchID( $search_id )
    {
        $result = new \Models\Result;
        $resultMapper = new \Models\Mappers\ResultMapper( $this->container );
        $resultMapper->mapFromSearchID( $result, $search_id );

        return $result;
    }

    public function getAll()
    {
        $resultMapper = new \Models\Mappers\ResultMapper( $this->container );
        $results = $resultMapper->mapAll();

        return $results;
    }

}
