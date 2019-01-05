<?php

namespace Model;

use Contracts\EntityInterface;

class Sequence implements EntityInterface
{
    public $id;
    public $checked_out;
}
