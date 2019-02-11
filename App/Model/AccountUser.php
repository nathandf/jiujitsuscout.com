<?php

namespace Model;

use Contracts\EntityInterface;

class AccountUser implements EntityInterface
{
    public $id;
    public $account_id;
    public $user_id;
}
