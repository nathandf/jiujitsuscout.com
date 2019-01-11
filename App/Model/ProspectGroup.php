<?php

namespace Model;

use Contracts\EntityInterface;

class ProspectGroup implements EntityInterface
{
	public $id;
	public $prospect_id;
	public $group_id;
}
