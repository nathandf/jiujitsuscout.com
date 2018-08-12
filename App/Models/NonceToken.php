<?php

namespace Model;

use Contracts\EntityInterface;

class NonceToken implements EntityInterface
{
	public $id;
	public $value;
	public $expiration;
}
