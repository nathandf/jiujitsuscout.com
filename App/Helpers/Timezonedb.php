<?php

namespace Helpers;

class Timezonedb
{
    public $api_key;
    public $gateway;
    public $endpoint;

    public function __construct( \Conf\Config $config )
    {
        $this->api_key = $config::$configs[ "timezonedb" ][ "api_key" ];
        $this->gateway = $config::$configs[ "timezonedb" ][ "gateway" ];
    }

    public function setEndpoint( $endpoint )
    {
        $this->endpoint = $endpoint;
    }

    public function getTimezoneByIP( $ip )
    {
        $this->setEndpoint( "get-time-zone" );
        $contents = false;
        try {
            $contents = @file_get_contents( "{$this->gateway}{$this->endpoint}?key={$this->api_key}&format=json&by=ip&ip={$ip}" );
        } catch ( \Exception $e ) {
            // TODO add logger
        }

        if ( $contents === false  || $contents === null ) {
            return false;
        }

        $timezone = json_decode( $contents );

        return $timezone;
    }

    public function getTimezoneByName( $name )
    {
        $this->setEndpoint( "get-time-zone" );
        $contents = false;
        try {
            $contents = @file_get_contents( "{$this->gateway}{$this->endpoint}?key={$this->api_key}&format=json&by=name&name={$name}" );
        } catch ( \Exception $e ) {
            // TODO add logger
        }

        if ( $contents === false  || $contents === null ) {
            return false;
        }

        $timezone = json_decode( $contents );

        return $timezone;
    }

}
