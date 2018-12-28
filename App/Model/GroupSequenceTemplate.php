<?php

namespace Model;

use Contracts\EntityInterface;

class GroupSequenceTemplate implements EntityInterface
{
    public $id;
    public $group_id;
    public $sequence_template_id;
}
