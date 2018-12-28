<?php

namespace Model\Services;

class DisciplineRepository extends Repository
{

    public function getAll()
    {
        $mapper = $this->getMapper();
        $disciplines = $mapper->mapAll();

        return $disciplines;
    }

    public function getByID( $id )
    {
        $mapper = $this->getMapper();
        $discipline = $mapper->mapFromID( $id );

        return $discipline;
    }

    public function getByName( $name )
    {
        $mapper = $this->getMapper();
        $discipline = $mapper->mapFromName( $name );

        return $discipline;
    }

}
