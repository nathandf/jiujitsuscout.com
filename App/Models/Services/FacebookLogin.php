<?php

namespace Models\Services;

class FacebookLogin
{

	public function __construct( \Models\Services\FacebookAPIInitializer $FacebookAPIInitializer )
	{
		$this->fb = $FacebookAPIInitializer->init();
	}

}
