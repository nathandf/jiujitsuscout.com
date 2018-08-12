<?php

namespace Model;

use Contracts\EntityInterface;

class PasswordReset implements EntityInterface
{
	public $id;
	public $email;
	public $nonce_token_id;
}
