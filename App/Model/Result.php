<?php

namespace Model;

use Contracts\EntityInterface;

class Result implements EntityInterface
{
	public $id;
	public $search_id;
	public $business_ids;
}
