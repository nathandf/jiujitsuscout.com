<?php

namespace Model;

use Contracts\EntityInterface;

class SmsConversation implements EntityInterface
{
	public $id;
	public $phone_number_1;
	public $phone_number_2;
}