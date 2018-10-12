<?php
/*
* Front Controller
*/
// autoloading native classes and third party libraries. Check composer.json for details
require_once( "App/vendor/autoload.php" );

require_once( "App/Helpers/debug.php" );

// Dependency injection container
$container = new Core\DI_Container;

// Environment
Conf\Config::setEnv( "production" );

// Load services using DI_Container
require_once( "App/Conf/services.php" );

// Error handling
Core\Error::setEnv( Conf\Config::getEnv() );
error_reporting( E_ALL );
// set_error_handler( "Core\Error::errorHandler" );
// set_exception_handler( "Core\Error::exceptionHandler" );

// Session and token handling
$session = $container->getService( "session" );

// routing
$Router = new Core\Router;

// routes
require_once( "App/Conf/routes.php" );

$request = $Router->dispatch( $_SERVER[ "QUERY_STRING" ] );
$controller_name = $request[ "controller" ];
$method = $request[ "method" ];
$params = $request[ "params" ];

$controller = new $controller_name( $container, $session, $params );
$controller->$method();
