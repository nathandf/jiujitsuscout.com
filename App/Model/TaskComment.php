<?php

namespace Model;

use Contracts\EntityInterface;

class TaskComment implements EntityInterface
{
	public $id;
	public $task_id;
	public $body;
	public $created_at;
}