<?php

namespace Model;

use Contracts\EntityInterface;

class TwilioPhoneNumber implements EntityInterface
{
	public $id;
	public $business_id;
	public $sid;
	public $phone_number;
	public $friendly_name;
}
