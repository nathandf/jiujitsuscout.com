<?php

namespace Model;

use Contracts\EntityInterface;

class ProductAccountType implements EntityInterface
{
    public $id;
    public $product_id;
    public $account_type_id;
}
