<?php

namespace Model;

use Contracts\EntityInterface;

class AccountType implements EntityInterface
{

  public $id;
  public $name;
  public $description;
  public $max_users;

}
