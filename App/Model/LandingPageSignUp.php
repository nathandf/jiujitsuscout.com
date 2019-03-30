<?php

namespace Model;

use Contracts\EntityInterface;

class LandingPageSignUp implements EntityInterface
{
	public $id;
	public $landing_page_id;
	public $token;
}