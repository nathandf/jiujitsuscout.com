<?php

namespace Model;

use Contracts\EntityInterface;

class SequenceTemplate implements EntityInterface
{
    public $id;
    public $business_id;
    public $name;
    public $description;
}
