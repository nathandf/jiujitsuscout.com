<?php

namespace Model;

use Contracts\EntityInterface;

class Product implements EntityInterface
{
    public $id;
    public $product_type_id;
    public $price;
    public $currency;
    public $name;
    public $description;
}
