<?php

namespace Model\Services;

class ProgramRepository extends Repository
{
    public function getAll()
    {
        $mapper = $this->getMapper();
        $programs = $mapper->mapAll();

        return $programs;
    }
}
