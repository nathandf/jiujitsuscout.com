<?php

namespace Model;

use Contracts\EntityInterface;

class Click implements EntityInterface
{
	public $id;
	public $business_id;
	public $ip;
	public $property;
	public $timestamp;
}
