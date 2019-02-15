<?php

namespace Model;

use Contracts\EntityInterface;

class ProspectAppraiserDetails implements EntityInterface
{
	public $id;
	public $business_id;
	public $base_price;
	public $base_question_value;
}