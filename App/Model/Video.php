<?php

namespace Model;

use Contracts\EntityInterface;

class Video implements EntityInterface
{
	public $id;
	public $business_id;
	public $name;
	public $description;
	public $filename;
	public $type;
	public $created_at;
	public $updated_at;
}
