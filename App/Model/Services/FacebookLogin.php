<?php

namespace Model\Services;

class FacebookLogin
{

	public function __construct( \Model\Services\FacebookAPIInitializer $FacebookAPIInitializer )
	{
		$this->fb = $FacebookAPIInitializer->init();
	}

}
