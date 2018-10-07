<?php

namespace Model;

use Contracts\EntityInterface;

class Question implements EntityInterface
{
	public $id;
	public $questionnaire_id;
	public $placement;
	public $text;
}
