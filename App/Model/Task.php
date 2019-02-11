<?php

namespace Model;

use Contracts\EntityInterface;

class Task implements EntityInterface
{
    public $business_id;
    public $created_by_user_id;
    public $due_date;
    public $trigger_time;
    public $title;
    public $message;
    public $priority;
    public $remind_status;
    public $status;
    public $checked_out;
}
