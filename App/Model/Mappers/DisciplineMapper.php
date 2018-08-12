<?php

namespace Model\Mappers;

class DisciplineMapper extends DataMapper
{
    public $data;

    public function mapAll()
    {
        $entityFactory = $this->container->getService( "entity-factory" );
        $disciplines = [];

        $sql = $this->DB->prepare( "SELECT * FROM discipline" );
        $sql->execute();

        while ( $resp = $sql->fetch( \PDO::FETCH_ASSOC ) ) {
            $discipline = $entityFactory->build( "Discipline" );
            $this->populateDiscipline( $discipline, $resp );
            $disciplines[] = $discipline;
        }

        return $disciplines;
    }

    public function mapFromID( $id )
    {
        $entityFactory = $this->container->getService( "entity-factory" );

        $sql = $this->DB->prepare( "SELECT * FROM discipline WHERE id = :id" );
        $sql->bindParam( ":id", $id );
        $sql->execute();

        $resp = $sql->fetch( \PDO::FETCH_ASSOC );
        $discipline = $entityFactory->build( "Discipline" );
        $this->populateDiscipline( $discipline, $resp );

        return $discipline;
    }

    public function mapFromName( $name )
    {
        $entityFactory = $this->container->getService( "entity-factory" );

        $sql = $this->DB->prepare( "SELECT * FROM discipline WHERE name = :name" );
        $sql->bindParam( ":name", $name );
        $sql->execute();

        $resp = $sql->fetch( \PDO::FETCH_ASSOC );
        $discipline = $entityFactory->build( "Discipline" );
        $this->populateDiscipline( $discipline, $resp );

        return $discipline;
    }

    public function populateDiscipline( $discipline, $data )
    {
        $discipline->id               = $data[ "id" ];
        $discipline->name             = $data[ "name" ];
        $discipline->nice_name        = $data[ "nice_name" ];
        $discipline->abbreviation     = $data[ "abbreviation" ];
    }
}
