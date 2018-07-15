<?php

namespace Conf;

class Config
{
    private static $environments = [ "development", "staging", "production" ];
    public static $environment;
    public static $configs;

    public function __construct()
    {
        require( "App/Conf/configs.php" );
        self::$configs = $config;
    }

    public static function setEnv( $environment )
    {
        if ( !in_array( $environment, self::$environments ) ) {
            throw new \Exception( "\"{$environment}\" is not valid environment - Environments list [ " . implode( ",", self::$environments ) ." ]" );
        }

        self::$environment = $environment;
    }

    public static function getEnv()
    {
        return self::$environment;
    }
}
