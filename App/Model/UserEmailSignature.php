<?php

namespace Model;

use Contracts\EntityInterface;

class UserEmailSignature implements EntityInterface
{
    public $id;
    public $user_id;
    public $body;
}
