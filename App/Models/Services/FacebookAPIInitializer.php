<?php

namespace Models\Services;

use Facebook\Facebook;
use Facebook\Api;

class FacebookAPIInitializer
{
	public $configs;
	public $server_environment;

	public function __construct( \Conf\Config $Config )
	{
		// Get facebook configs
		$this->configs = $Config::$configs[ "facebook" ][ "api" ];

		// Set server environment
		$this->server_environment = $Config::getEnv();
	}

	public function init()
	{
		// Get initialize facebook api
		$Facebook = new Facebook(
			[
				"app_id" => $this->configs[ "{$this->server_environment}" ][ "app_id" ],
				"app_secret" => $this->configs[ "{$this->server_environment}" ][ "app_secret" ],
				"default_graph_version" => $this->configs[ "default_graph_version" ]
			]
		);

		return $Facebook;
	}
}
