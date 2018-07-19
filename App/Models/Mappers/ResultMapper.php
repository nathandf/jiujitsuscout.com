<?php

namespace Models\Mappers;

class ResultMapper extends DataMapper
{

    public function create( \Models\Result $result )
    {
        $id = $this->insert(

            "result",

            [
                "search_id",
                "business_ids"
            ],

            [
                $result->search_id,
                $result->business_ids
            ]
        );
        $result->id = $id;

        return $result;
    }

    public function mapFromID( \Models\Result $result, $id )
    {
        $sql = $this->DB->prepare( "SELECT * FROM `result` WHERE id = :id" );
        $sql->bindParam( ":id", $id );
        $sql->execute();
        $resp = $sql->fetch( \PDO::FETCH_ASSOC );
        $this->populateResult( $result, $resp );

        return $result;
    }

    public function mapFromSearchID( \Models\Result $result, $search_id )
    {
        $sql = $this->DB->prepare( "SELECT * FROM `result` WHERE search_id = :search_id" );
        $sql->bindParam( ":search_id", $search_id );
        $sql->execute();
        $resp = $sql->fetch( \PDO::FETCH_ASSOC );
        $this->populateResult( $result, $resp );

        return $result;
    }

    public function mapAll()
    {
        $entityFactory = $this->container->getService( "entity-factory" );

        $results = [];

        $sql = $this->DB->prepare( "SELECT * FROM `result`" );
        $sql->execute();

        while ( $resp = $sql->fetch( \PDO::FETCH_ASSOC ) ) {
            $result = $entityFactory->build( "Result" );
            $this->populateResult( $result, $resp );

            $results[] = $result;
        }

        return $results;
    }

    public function populateResult( $result, $data )
    {
        $result->id                 = $data[ "id" ];
        $result->search_id          = $data[ "search_id" ];
        $result->business_ids       = $data[ "business_ids" ];
    }

}
