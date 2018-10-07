<?php

namespace Model;

use Contracts\EntityInterface;

// A person who takes part in a questionnaire
class Respondent implements EntityInterface
{
	public $id;
	public $questionnaire_id;
	public $questionnaire_complete;
	public $last_question_id;
	public $prospect_id;
	public $token;
}
