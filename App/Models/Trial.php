<?php

namespace Models;

use Contracts\EntityInterface;

class Trial implements EntityInterface
{
  
  public $id;
  public $business_id;
  public $prospect_id
  public $start_date;
  public $end_date;

}
