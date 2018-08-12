<?php

namespace Model;

use Contracts\EntityInterface;

class Currency implements EntityInterface
{
	public $country;
	public $currency;
	public $code;
	public $symbol;
}
