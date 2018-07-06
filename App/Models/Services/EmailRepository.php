<?php

namespace Models\Services;

class EmailRepository extends Service
{

  public function getAll()
  {
    $emailMapper = new \Models\Mappers\EmailMapper( $this->container );
    $emails = $emailMapper->mapAll();
    return $emails;
  }

  public function getByID( $id )
  {
    $email = new \Models\Email();
    $emailMapper = new \Models\Mappers\EmailMapper( $this->container );
    $emailMapper->mapFromID( $email, $id );
    return $email;
  }
  
}
