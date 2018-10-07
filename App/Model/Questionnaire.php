<?php

namespace Model;

use Contracts\EntityInterface;

class Questionnaire implements EntityInterface
{
	public $id;
	public $name;
	public $description;
}
