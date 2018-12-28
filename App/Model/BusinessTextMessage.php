<?php

namespace Model;

use Contracts\EntityInterface;

class BusinessTextMessage implements EntityInterface
{
    public $id;
    public $business_id;
    public $text_message_id;
}
