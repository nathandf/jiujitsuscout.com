<?php

namespace Models;

// NOTE - order is an SQL keyword. Use tic marks in queries - " `order` "
class Order
{
    public $id;
    public $account_id;
    public $customer_id;
    public $paid;
    public $total;
}
