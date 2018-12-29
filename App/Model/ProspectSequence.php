<?php

namespace Model;

use Contracts\EntityInterface;

class ProspectSequence implements EntityInterface
{
	public $id;
	public $prospect_id;
	public $sequence_id;
}
