<?php

namespace Model;

use Contracts\EntityInterface;

class BusinessSequence implements EntityInterface
{
    public $id;
    public $business_id;
    public $sequence_id;
}
