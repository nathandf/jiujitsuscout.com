<?php

namespace Models;

use Contracts\EntityInterface;

class Task implements EntityInterface
{
    public $business_id;
    public $assignee_user_id;
    public $created_by_user_id;
    public $due_date;
    public $message;
    public $remind_status;
    public $status;
}
