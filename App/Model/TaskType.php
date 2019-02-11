<?php

namespace Model;

use Contracts\EntityInterface;

class TaskType implements EntityInterface
{
	public $id;
	public $name;
	public $description;
}