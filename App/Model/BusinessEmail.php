<?php

namespace Model;

use Contracts\EntityInterface;

class BusinessEmail implements EntityInterface
{
    public $id;
    public $business_id;
    public $email_id;
}
