<?php

namespace Core;

class Request
{
	private $origin_whitelist = [];

	public function whitelistOrigin( $origins )
	{
		if ( is_array( $origins ) ) {
			foreach ( $origins as $origin ) {
				$this->origin_whitelist[] = $origin
			}

			return;
		}

		$this->origin_whitelist[] = $origins;

		return;
	}

	public function allowOrigin( $origin )
	{
		if ( in_array( $origin, $this->origin_whitelist ) ) {
			header( "Access-Control-Allow-Origin: " . $origin );

			return true;
		}

		return false;
	}

	public function getOrigin()
	{
		if ( array_key_exists( "HTTP_ORIGIN", $_SERVER ) ) {
			$origin = $_SERVER[ "HTTP_ORIGIN" ];
		} elseif ( array_key_exists( "HTTP_REFERER", $_SERVER ) ) {
			$origin = $_SERVER[ "HTTP_REFERER" ];
		} else {
			$origin = $_SERVER[ "REMOTE_ADDR" ];
		}

		return $origin;
	}

}
