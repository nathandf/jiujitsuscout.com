<?php

namespace Model;

use Contracts\EntityInterface;

class AccountUser extends EntityInterface
{
    public $id;
    public $account_id;
    public $user_id;
}
