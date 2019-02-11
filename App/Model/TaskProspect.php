<?php

namespace Model;

use Contracts\EntityInterface;

class TaskProspect implements EntityInterface
{
	public $id;
	public $task_id;
	public $prospect_id;
}