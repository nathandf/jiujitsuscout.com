<?php

namespace Model\Services;

class ProgramRepository extends Service
{

  public function getAll()
  {
    $programMapper = new \Model\Mappers\ProgramMapper( $this->container );
    $programs = $programMapper->mapAll();
    return $programs;
  }

}
