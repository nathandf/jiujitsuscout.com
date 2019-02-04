<?php

namespace Model;

use Contracts\EntityInterface;

class MemberGroup implements EntityInterface
{
	public $id;
	public $member_id;
	public $group_id;
}
