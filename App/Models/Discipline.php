<?php

namespace Models;

use Contracts\EntityInterface;

class Discipline implements EntityInterface
{

  public $id;
  public $name;
  public $nice_name;
  public $abbreviation;

}
