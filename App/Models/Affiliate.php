<?php

namespace Models;

use Contracts\EntityInterface;

class Affiliate implements EntityInterface
{
	public $id;
	public $business_id;
	public $affiliation_id;
}
