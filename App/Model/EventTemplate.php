<?php

namespace Model;

use Contracts\EntityInterface;

class EventTemplate implements EntityInterface
{
    public $id;
    public $sequence_template_id;
    public $event_type_id;
    public $email_template_id;
    public $text_message_template_id;
    public $wait_duration; // in seconds
}
