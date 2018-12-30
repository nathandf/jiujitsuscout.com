<?php

namespace Model\Mappers;

class SearchMapper extends DataMapper
{
    public function create( \Model\Search $search )
    {
        $id = $this->insert(
            "search",
            [
                "ip",
                "query",
                "time"
            ],
            [
                $search->ip,
                $search->query,
                $search->time
            ]
        );
        $search->id = $id;

        return $search;
    }

    public function mapFromID( \Model\Search $search, $id )
    {
        $sql = $this->DB->prepare( "SELECT * FROM `search` WHERE id = :id" );
        $sql->bindParam( ":id", $id );
        $sql->execute();
        $resp = $sql->fetch( \PDO::FETCH_ASSOC );
        $this->populate( $search, $resp );

        return $search;
    }

    public function mapAll()
    {
        $searches = [];

        $sql = $this->DB->prepare( "SELECT * FROM `search`" );
        $sql->execute();

        while ( $resp = $sql->fetch( \PDO::FETCH_ASSOC ) ) {
            $search = $this->entityFactory->build( "Search" );
            $this->populate( $search, $resp );

            $searches[] = $search;
        }

        return $searches;
    }
}
