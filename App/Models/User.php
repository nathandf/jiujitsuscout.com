<?php

namespace Models;

use Contracts\UserInterface;
use Contracts\EntityInterface;

class User implements UserInterface, EntityInterface
{
  public $first_name;
  public $last_name;
  public $email;
  public $number;
  public $current_business_id = null;

  public function setFirstName( $first_name )
  {
    $this->first_name = $first_name;
  }

  public function setLastName( $last_name )
  {
    $this->last_name = $last_name;
  }

  public function setEmail( $email )
  {
    $this->email = $email;
  }

  public function setPhoneNumber( $number )
  {
    $this->number = $number;
  }

  public function setCurrentBusinessID( $business_id )
  {
    $this->current_business_id = $business_id;
  }

  public function getCurrentBusinessID()
  {
    return $this->current_business_id;
  }

}
