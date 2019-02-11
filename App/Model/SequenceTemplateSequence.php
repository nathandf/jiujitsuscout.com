<?php

namespace Model;

use Contracts\EntityInterface;

class SequenceTemplateSequence implements EntityInterface
{
    public $id;
    public $sequence_template_id;
    public $sequence_id;
}
