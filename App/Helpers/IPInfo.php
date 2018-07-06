<?php

namespace Helpers;

class IPInfo
{
    public $access_token;
    public $ip;

    public function __construct( \Conf\Config $config )
    {
        $this->access_token = $config::$configs[ "ipinfo" ][ "access_token" ];
        $this->setIP( $this->getIPFromServer() );
    }

    public function getIPFromServer()
    {
        return $_SERVER[ "REMOTE_ADDR" ];
    }

    public function getIP()
    {
        return $this->ip;
    }

    public function setIP( $ip )
    {
        $this->ip = $ip;
        //$this->ip = "192.169.235.224";
        // $this->ip = "1.8.255.255";
    }

    public function getGeoByIP()
    {
        if ( $this->ip != "::1" && $this->ip != "127.0.0.1" ) {
            // Default contents to false
            $contents = false;
            try {
                $contents = @file_get_contents( "http://ipinfo.io/{$this->ip}/?token={$this->access_token}" );
            } catch ( \Exception $e ) {
                // TODO add logger
            }

            $geo = json_decode( $contents );

            return $geo;
        }

        return false;
    }

}
