<?php

namespace Models\Services;

class ProgramRepository extends Service
{

  public function getAll()
  {
    $programMapper = new \Models\Mappers\ProgramMapper( $this->container );
    $programs = $programMapper->mapAll();
    return $programs;
  }

}
