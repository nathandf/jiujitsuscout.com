<?php

namespace Model;

use Contracts\EntityInterface;

class LandingPageLeadCapture implements EntityInterface
{
	public $id;
	public $landing_page_id;
	public $lead_capture_id;
}