<?php

namespace Conf;

class Config
{
  public static $environment;
  public static $configs;

  public function __construct()
  {
    require( "App/Conf/configs.php" );
    self::$configs = $config;
  }

  public static function setEnv( $environment )
  {
    self::$environment = $environment;
  }

  public static function getEnv()
  {
    return self::$environment;
  }
}
