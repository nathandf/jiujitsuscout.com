<?php

namespace Model;

use Contracts\EntityInterface;

class TextMessage implements EntityInterface
{
  public $id;
  public $body;
}
