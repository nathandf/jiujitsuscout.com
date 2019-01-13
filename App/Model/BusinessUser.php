<?php

namespace Model;

use Contracts\EntityInterface;

class BusinessUser implements EntityInterface
{
    public $id;
    public $business_id;
    public $user_id;
}
