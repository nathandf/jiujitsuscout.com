<?php

namespace Model\Services;

class ResultRepository extends Repository
{

    public function create( $search_id, $business_ids )
    {
        $mapper = $this->getMapper();
        $result = $mapper->build( $this->entityName );
        $result->search_id = $search_id;
        $result->business_ids = $business_ids;
        $mapper->create( $result );

        return $result;
    }

    public function getByID( $id )
    {
        $mapper = $this->getMapper();
        $result = $mapper->build( $this->entityName );
        $mapper->mapFromID( $result, $id );

        return $result;
    }

    public function getBySearchID( $search_id )
    {
        $mapper = $this->getMapper();
        $result = $mapper->build( $this->entityName );
        $mapper->mapFromSearchID( $result, $search_id );

        return $result;
    }

    public function getAll()
    {
        $mapper = $this->getMapper();
        $results = $mapper->mapAll();

        return $results;
    }

}
