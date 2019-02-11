<?php

namespace Model;

use Contracts\EntityInterface;

class TaskMember implements EntityInterface
{
	public $id;
	public $task_id;
	public $member_id;
}