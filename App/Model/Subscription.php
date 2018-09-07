<?php

namespace Model;

use Contracts\EntityInterface;

class Subscription implements EntityInterface
{
    public $id;
    public $account_id;
    public $price;
    public $billing_cycle_interval;
    public $start_date;
    public $end_date;
    public $created_at;
    public $updated_at;
}
