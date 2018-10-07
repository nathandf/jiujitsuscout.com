<?php

namespace Model\Services;

class DisciplineRepository extends Service
{

    public function getAll()
    {
        $disciplineMapper = new \Model\Mappers\DisciplineMapper( $this->container );
        $disciplines = $disciplineMapper->mapAll();

        return $disciplines;
    }

    public function getByID( $id )
    {
        $disciplineMapper = new \Model\Mappers\DisciplineMapper( $this->container );
        $discipline = $disciplineMapper->mapFromID( $id );

        return $discipline;
    }

    public function getByName( $name )
    {
        $disciplineMapper = new \Model\Mappers\DisciplineMapper( $this->container );
        $discipline = $disciplineMapper->mapFromName( $name );

        return $discipline;
    }

}
