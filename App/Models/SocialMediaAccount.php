<?php

namespace Models;

use Contracts\EntityInterface;

class SocialMediaAccount implements EntityInterface
{
	public $id;
	public $social_media_account_type;
	public $url;
}
