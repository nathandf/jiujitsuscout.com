<?php

namespace Model\Mappers;

class ResultMapper extends DataMapper
{
    public function create( \Model\Result $result )
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

    public function mapFromID( \Model\Result $result, $id )
    {
        $sql = $this->DB->prepare( "SELECT * FROM `result` WHERE id = :id" );
        $sql->bindParam( ":id", $id );
        $sql->execute();
        $resp = $sql->fetch( \PDO::FETCH_ASSOC );
        $this->populate( $result, $resp );

        return $result;
    }

    public function mapFromSearchID( \Model\Result $result, $search_id )
    {
        $sql = $this->DB->prepare( "SELECT * FROM `result` WHERE search_id = :search_id" );
        $sql->bindParam( ":search_id", $search_id );
        $sql->execute();
        $resp = $sql->fetch( \PDO::FETCH_ASSOC );
        $this->populate( $result, $resp );

        return $result;
    }

    public function mapAll()
    {
        $results = [];

        $sql = $this->DB->prepare( "SELECT * FROM `result`" );
        $sql->execute();

        while ( $resp = $sql->fetch( \PDO::FETCH_ASSOC ) ) {
            $result = $this->entityFactory->build( "Result" );
            $this->populate( $result, $resp );

            $results[] = $result;
        }

        return $results;
    }
}
