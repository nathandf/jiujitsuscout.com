<?php

namespace Models\Services;

class SearchRepository extends Service
{

    public function create( $ip, $query, $time )
    {
        $search = new \Models\Search;
        $searchMapper = new \Models\Mappers\SearchMapper( $this->container );
        $search->ip = $ip;
        $search->query = $query;
        $search->time = $time;
        $searchMapper->create( $search );

        return $search;
    }

    public function getByID( $id )
    {
        $search = new \Models\Search;
        $searchMapper = new \Models\Mappers\SearchMapper( $this->container );
        $searchMapper->mapFromID( $search, $id );

        return $search;
    }

    public function getAll()
    {
        $searchMapper = new \Models\Mappers\SearchMapper( $this->container );
        $searches = $searchMapper->mapAll();

        return $searches;
    }

}
