<?php

namespace Model;

use Contracts\EntityInterface;

class EmbeddableFormGroup implements EntityInterface
{
    public $id;
    public $embeddable_form_id;
    public $group_id;
}
