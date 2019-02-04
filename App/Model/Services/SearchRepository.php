<?php

namespace Model\Services;

class SearchRepository extends Repository
{
    public function create( $ip, $query, $time )
    {
        $mapper = $this->getMapper();
        $search = $mapper->build( $this->entityName );
        $search->ip = $ip;
        $search->query = $query;
        $search->time = $time;
        $mapper->create( $search );

        return $search;
    }

    public function getByID( $id )
    {
        $mapper = $this->getMapper();
        $search = $mapper->build( $this->entityName );
        $mapper->mapFromID( $search, $id );

        return $search;
    }

    public function getAll()
    {
        $mapper = $this->getMapper();
        $searches = $mapper->mapAll();

        return $searches;
    }
}
