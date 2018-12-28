<?php

namespace Model;

use Contracts\EntityInterface;

class TextMessage implements EntityInterface, Textable
{
    public $id;
    public $body;
    public $sender_phone_number;
    public $recipient_phone_number;
}
