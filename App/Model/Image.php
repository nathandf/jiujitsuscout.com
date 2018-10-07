<?php

namespace Model;

use Contracts\EntityInterface;

class Image implements EntityInterface
{
	public $id;
	public $business_id;
	public $filename;
	public $description;
	public $alt;
	public $tags;
}
