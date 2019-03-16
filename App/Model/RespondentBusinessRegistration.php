<?php

namespace Model;

use Contracts\EntityInterface;

class RespondentBusinessRegistration implements EntityInterface
{
	public $id;
	public $respondent_id;
	public $business_id;
}