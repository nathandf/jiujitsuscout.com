<?php

namespace Models\Mappers;

class SearchMapper extends DataMapper
{

    public function create( \Models\Search $search )
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

    public function mapFromID( \Models\Search $search, $id )
    {
        $sql = $this->DB->prepare( "SELECT * FROM `search` WHERE id = :id" );
        $sql->bindParam( ":id", $id );
        $sql->execute();
        $resp = $sql->fetch( \PDO::FETCH_ASSOC );
        $this->populateSearch( $search, $resp );

        return $search;
    }

    public function mapAll()
    {
        $entityFactory = $this->container->getService( "entity-factory" );

        $searches = [];

        $sql = $this->DB->prepare( "SELECT * FROM `search`" );
        $sql->execute();

        while ( $resp = $sql->fetch( \PDO::FETCH_ASSOC ) ) {
            $search = $entityFactory->build( "Search" );
            $this->populateSearch( $search, $resp );

            $searches[] = $search;
        }

        return $searches;
    }

    public function populateSearch( $search, $data )
    {
        $search->id                 = $data[ "id" ];
        $search->ip                 = $data[ "ip" ];
        $search->query              = $data[ "query" ];
        $search->time               = $data[ "time" ];
    }

}
