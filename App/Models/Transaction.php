<?php

namespace Models;

class Transaction
{
    public $id;
    public $customer_id;
    public $order_id;
    public $status;
    public $transaction_type;
    public $amount;
    public $created_at;
    public $updated_at;
}
