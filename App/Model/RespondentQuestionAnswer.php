<?php

namespace Model;

use Contracts\EntityInterface;

class RespondentQuestionAnswer implements EntityInterface
{
	public $id;
	public $respondent_id;
	public $question_id;
	public $question_choice_id;
	public $text;
}
