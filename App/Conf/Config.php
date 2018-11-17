<?php

namespace Conf;

class Config
{
    private static $environments = [ "development", "staging", "production" ];
    public static $environment;
    public static $configs;

    public static function setEnv( $environment )
    {
        require( "App/Conf/configs.php" );
        self::$configs = $config;

        if ( !in_array( $environment, self::$environments ) ) {
            throw new \Exception( "\"{$environment}\" is not valid environment - Environments list [ " . implode( ",", self::$environments ) ." ]" );
        }

        self::$environment = $environment;

        // Make sure people aint stealing my shit
        if ( $environment == "production" && $_SERVER[ "REMOTE_ADDR" ] != "::1" ) {
            if ( !in_array( $_SERVER[ "SERVER_NAME" ], self::$configs[ "approved_server_names" ] ) ) {
                header( "location: " . self::$configs[ "routing" ][ "production" ][ "root" ] );
            }
        }

        // Prohibit search engines from index develop or staging sites
        if ( !in_array( $_SERVER[ "SERVER_NAME" ], self::$configs[ "indexable_domains" ] ) ) {
            header( "X-Robots-Tag: noindex, nofollow", true );
        }

    }

    public static function getEnv()
    {
        return self::$environment;
    }
}
