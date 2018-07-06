<?php

namespace Models\Services;

class DisciplineRepository extends Service
{

    public function getAll()
    {
        $disciplineMapper = new \Models\Mappers\DisciplineMapper( $this->container );
        $disciplines = $disciplineMapper->mapAll();

        return $disciplines;
    }

    public function getByID( $id )
    {
        $disciplineMapper = new \Models\Mappers\DisciplineMapper( $this->container );
        $discipline = $disciplineMapper->mapFromID( $id );

        return $discipline;
    }

    public function getByName( $name )
    {
        $disciplineMapper = new \Models\Mappers\DisciplineMapper( $this->container );
        $discipline = $disciplineMapper->mapFromName( $name );

        return $discipline;
    }

}
