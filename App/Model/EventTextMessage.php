<?php

namespace Model;

use Contracts\EntityInterface;

class EventTextMessage implements EntityInterface
{
    public $id;
    public $text_message_id;
}
