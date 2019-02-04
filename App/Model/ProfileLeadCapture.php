<?php

namespace Model;

use Contracts\EntityInterface;

class ProfileLeadCapture implements EntityInterface
{
	public $id;
	public $business_id;
	public $lead_capture_id;
}