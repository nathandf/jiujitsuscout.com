<?php

namespace Model;

// NOTE - order is an SQL keyword. Use tic marks in queries - " `order` "
class Order
{
    public $id;
    public $customer_id;
    public $paid;
}
