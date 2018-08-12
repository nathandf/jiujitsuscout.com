<?php

namespace Model;

use Contracts\EntityInterface;

class Program implements EntityInterface
{

  public $id;
  public $name;
  public $nice_name;
  public $abbreviation;

}
