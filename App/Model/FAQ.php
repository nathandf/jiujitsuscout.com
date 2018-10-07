<?php

namespace Model;

use Contracts\EntityInterface;

class FAQ implements EntityInterface
{
    public $id;
    public $placement;
    public $text;
}
