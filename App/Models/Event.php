<?php

namespace Models;

use Contracts\EntityInterface;

class Event implements EntityInterface
{
    public $id;
    public $business_id;
    public $sequence_id;
    public $event_type_id;
    public $time;
    public $status;
}
