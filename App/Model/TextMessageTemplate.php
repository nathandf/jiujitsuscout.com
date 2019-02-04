<?php

namespace Model;

use Contracts\EntityInterface;

class TextMessageTemplate implements EntityInterface
{
    public $id;
    public $name;
    public $description;
    public $body;
}
