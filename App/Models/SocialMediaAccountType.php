<?php

namespace Model;

use Contracts\EntityInterface;

class SocialMediaAccountType implements EntityInterface
{
	public $id;
	public $name;
	public $description;
}
