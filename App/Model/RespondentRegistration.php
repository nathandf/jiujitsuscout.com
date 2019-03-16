<?php

namespace Model;

use Contracts\EntityInterface;

class RespondentRegistration implements EntityInterface
{
	public $id;
	public $respondent_id;
	public $first_name;
	public $last_name;
	public $email;
	public $phone_id;
}