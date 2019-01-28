<?php

namespace Model;

use Contracts\EntityInterface;

class EmbeddableFormSequenceTemplate implements EntityInterface
{
    public $id;
    public $embeddable_form_id;
    public $sequence_template_id;
}
