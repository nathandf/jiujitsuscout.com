<?php

namespace Models;

use Contracts\EntityInterface;
use Models\Person;

class Member extends Person implements EntityInterface
{
    public $id;
    public $business_id;
    public $group_ids;
    public $status;
    public $tuition_amount;
    public $billing_frequency;
    public $billing_start_date;
    public $billing_end_date;
    public $native_review;
    public $google_review;
    public $email_unsubscribe;

}
