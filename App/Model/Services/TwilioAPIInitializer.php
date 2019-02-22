<?php

namespace Model\Services;

use Twilio\Rest\Client;

class TwilioAPIInitializer
{
	public $configs;
	public $server_environment;
	public $status_callback;

	public function __construct( \Conf\Config $Config )
	{
		// Get facebook configs
		$this->setConfigs( $Config::$configs[ "twilio" ] );

		// Set server environment
		$this->setServerEnv( $Config::getEnv() );

		switch ( $this->server_environment ) {
			case "development":
				$this->setStatusCallback( "https://postb.in/oYxlZsq2" );
				break;
			case "production":
				$this->setStatusCallback( "https://www.jiujitsuscout.com/webhooks/twilio/status-callback" );
				break;
			default:
				$this->setStatusCallback( "https://www.jiujitsuscout.com/webhooks/twilio/status-callback" );
				break;
		}
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

	private function setConfigs( array $configs )
	{
		$this->configs = $configs;
	}

	public function getConfigs()
	{
		return $this->configs;
	}

	private function setServerEnv( $server_environment )
	{
		$this->server_environment = $server_environment;
	}

	public function getServerEnv()
	{
		return $this->server_environment;
	}

	private function setStatusCallback( $status_callback )
	{
		$this->status_callback = $status_callback;
	}

	public function getStatusCallback()
	{
		return $this->status_callback;
	}
}
