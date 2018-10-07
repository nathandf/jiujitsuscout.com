<?php

namespace Model;

use Contracts\EntityInterface;

class ProspectAppraisal implements EntityInterface
{
	public $id;
	public $prospect_id;
	public $value;
	public $currency;
}
