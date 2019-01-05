<?php

namespace Model;

use Contracts\EntityInterface;

class Event implements EntityInterface
{
    public $id;
    public $sequence_id;
    public $event_type_id;
    public $time;
    public $status;
}
