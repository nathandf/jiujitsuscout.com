<?php

namespace Model\Services;

class EmailRepository extends Service
{

  public function getAll()
  {
    $emailMapper = new \Model\Mappers\EmailMapper( $this->container );
    $emails = $emailMapper->mapAll();
    return $emails;
  }

  public function getByID( $id )
  {
    $email = new \Model\Email();
    $emailMapper = new \Model\Mappers\EmailMapper( $this->container );
    $emailMapper->mapFromID( $email, $id );
    return $email;
  }
  
}
