<?php

namespace Contracts;

interface UserInterface
{
  public function setFirstName( $first_name );

  public function setLastName( $first_name );

  public function setEmail( $email );

  public function setPhoneNumber( $number );
}
