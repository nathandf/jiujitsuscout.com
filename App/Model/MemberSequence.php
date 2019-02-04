<?php

namespace Model;

use Contracts\EntityInterface;

class MemberSequence implements EntityInterface
{
	public $id;
	public $member_id;
	public $sequence_id;
}
