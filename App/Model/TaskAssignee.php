<?php

namespace Model;

use Contracts\EntityInterface;

class TaskAssignee implements EntityInterface
{
	public $id;
	public $task_id;
	public $user_id;
}