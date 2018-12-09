<?php

namespace Model;

use Contracts\EntityInterface;

class EventTemplate implements EntityInterface
{
    public $id;
    public $sequence_template_id;
    public $event_type_id;
}
