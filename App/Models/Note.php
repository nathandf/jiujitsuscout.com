<?php

namespace Models;

use Contracts\EntityInterface;

class Note implements EntityInterface
{

  public $id;
  public $business_id;
  public $user_id;
  public $prospect_id;
  public $member_id;
  public $appointment_id;
  public $body;
  public $time;

}
