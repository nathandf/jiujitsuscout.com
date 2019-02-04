<?php

namespace Helpers;

use Contracts\GeocoderInterface;

class GoogleGeocoder implements GeocoderInterface
{
	public $gateway;
	public $api_key;

	public function __construct( \Conf\Config $config )
	{
		$this->gateway = $config::$configs[ "google" ][ "geocoding_api" ][ "gateway" ];
		$this->api_key = $config::$configs[ "google" ][ "api_key" ];
	}

	public function getGeoInfoByAddress( $address )
	{
		$address = urlencode( $address );

		$url = "{$this->gateway}?address={$address}&key={$this->api_key}";

		$curl = curl_init();
        curl_setopt( $curl, CURLOPT_RETURNTRANSFER, 1 );
        curl_setopt( $curl, CURLOPT_SSL_VERIFYPEER, false );

        curl_setopt( $curl, CURLOPT_URL, $url );

        $contents = curl_exec( $curl );

        curl_close( $curl );

		$contents = json_decode( $contents );

		return $contents;
	}
}
