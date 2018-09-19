<?php

namespace Model;

use Contracts\EntityInterface;

class QuestionChoiceWeight implements EntityInterface
{
	public $id;
	public $question_choice_id;
	public $weight;
}
