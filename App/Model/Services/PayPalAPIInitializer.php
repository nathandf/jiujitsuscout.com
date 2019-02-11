<?php

namespace Model\Services;

use PayPal\Rest\ApiContext;
use PayPal\Auth\OAuthTokenCredential;

class PayPalAPIInitializer
{
    private $configs;

    public function __construct( \Conf\Config $Config )
    {
        $this->configs = $Config::$configs[ "paypal" ][ "api" ];
    }

    public function init()
    {
        $api = new ApiContext(
            new OAuthTokenCredential(
                $this->configs[ "credentials" ][ "sandbox" ][ "client_id" ],
                $this->configs[ "credentials" ][ "sandbox" ][ "client_secret" ]
            )
        );

        $api->setConfig( [
            "mode" => "sandbox",
            "http.ConnectionTimeOut" => 30,
            "log.LogEnabled" => true,
            "log.FileName" => $this->configs[ "log_filename" ],
            "log.LogLevel" => "FINE",
            "validation.level" => "log"
        ] );

        return $api;
    }
}
