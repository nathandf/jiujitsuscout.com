<?php

namespace Model;

use Contracts\EntityInterface;

class Sequence implements EntityInterface
{
    public $id;
    public $business_id;
    public $name;
    public $description;
    public $event_ids;
    public $checked_out;
}
