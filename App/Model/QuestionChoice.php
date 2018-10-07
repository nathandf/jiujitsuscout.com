<?php

namespace Model;

use Contracts\EntityInterface;

class QuestionChoice implements EntityInterface
{
	public $id;
	public $question_choice_type_id;
	public $question_id;
	public $text;
}
