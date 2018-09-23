<?php

namespace Model;

use Contracts\EntityInterface;
use Model\Person;

class Prospect extends Person implements EntityInterface
{
    public $id;
    public $type;
    public $status;
    public $trial_start;
    public $trial_end;
    public $source;
    public $trial_remind_status;
    public $google_review_status;
    public $native_review_status;
    public $unsubscribe_email;
    public $unsubscribe_text;
    public $requires_purchase;
}
