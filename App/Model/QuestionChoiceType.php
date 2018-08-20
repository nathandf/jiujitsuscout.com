<?php

namespace Model;

use Contracts\EntityInterface;

class QuestionChoiceType implements EntityInterface
{
	public $id;
	public $name;
	public $description;
}
