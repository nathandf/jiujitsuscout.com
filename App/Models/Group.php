<?php

namespace Models;

use Contracts\EntityInterface;

class Group implements EntityInterface
{

  public $id;
  public $business_id;
  public $name;
  public $description;

}
