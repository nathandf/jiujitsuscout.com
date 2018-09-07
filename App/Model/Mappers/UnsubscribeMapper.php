<?php

namespace Model\Mappers;

use Model\Unsubscribe;

class UnsubscribeMapper extends DataMapper
{

    public function create( \Model\Unsubscribe $unsubscribe )
    {
        $id = $this->insert(
            "unsubscribe",
            [ "email" ],
            [ $unsubscribe->email ]
        );
        $unsubscribe->id = $id;

        return $unsubscribe;
    }

    public function mapFromID( Unsubscribe $unsubscribe, $id )
    {
        $sql = $this->DB->prepare( 'SELECT * FROM unsubscribe WHERE id = :id' );
        $sql->bindParam( ":id", $id );
        $sql->execute();
        $resp = $sql->fetch( \PDO::FETCH_ASSOC );
        $this->populateUnsubscribe( $unsubscribe, $resp );

        return $unsubscribe;
    }

    public function mapFromEmail( Unsubscribe $unsubscribe, $email )
    {
        $sql = $this->DB->prepare( 'SELECT * FROM unsubscribe WHERE email = :email' );
        $sql->bindParam( ":email", $email );
        $sql->execute();
        $resp = $sql->fetch( \PDO::FETCH_ASSOC );
        $this->populateUnsubscribe( $unsubscribe, $resp );

        return $unsubscribe;
    }

    public function mapAll()
    {
        $entityFactory = $this->container->getService( "entity-factory" );
        $unsubscribes = [];
        $sql = $this->DB->prepare( "SELECT * FROM unsubscribe" );
        $sql->execute();

        while ( $resp = $sql->fetch( \PDO::FETCH_ASSOC ) ) {
            $unsubscribe = $entityFactory->build( "Unsubscribe" );
            $this->populateUnsubscribe( $unsubscribe, $resp );
            $unsubscribes[] = $unsubscribe;
        }

        return $unsubscribes;
    }

    private function populateUnsubscribe( \Model\Unsubscribe $unsubscribe, $data )
    {
        $unsubscribe->id = $data[ "id" ];
        $unsubscribe->email = $data[ "email" ];
    }

}
