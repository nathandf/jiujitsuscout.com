<?php

namespace Model\Services;

use Twilio\Rest\Client;

class TwilioClientInitializer
{
	public $configs;
	public $server_environment;

	public function __construct( \Conf\Config $Config )
	{
		// Get facebook configs
		$this->configs = $Config::$configs[ "twilio" ];

		// Set server environment
		$this->server_environment = $Config::getEnv();
	}

	public function init()
	{
		// Get initialize facebook api
		$client = new Client(
			$this->configs[ "account_sid" ],
			$this->configs[ "auth_token" ]
		);

		return $client;
	}
}
