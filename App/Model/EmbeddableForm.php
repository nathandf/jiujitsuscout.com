<?php

namespace Model;

use Contracts\EntityInterface;

class EmbeddableForm implements EntityInterface
{
	public $id;
	public $business_id;
	public $name;
	public $offer;
}
