<?php
namespace Core;
/*
* Router class
*/
class Router
{
  protected $routes = [];
  // Parameters from the matched routes
  protected $params = [];
  private $configs;
  private $environment;

    public function __construct( \Conf\Config $Config )
    {
        $this->configs = $Config::$configs;
        $this->environment = $Config::getEnv();
    }

  // Add a route to the routing table
  public function add( $route, $params = [] )
  {
    // converting route to reg ex - escape forward slashes
    $route = preg_replace( '/\//', '\\/', $route );

    // converting variables e.g. {controller}
    $route = preg_replace( '/\{([a-z]+)\}/', '(?P<\1>[a-z-]+)', $route );

    // converting variables with custom regex
    $route = preg_replace( '/\{([a-z]+):([^\}]+)\}/', '(?P<\1>\2)', $route );

    // add start and end delimiters and case insensitive flag
    $route = '/^' . $route . '$/i';

    $this->routes[$route] = $params;
  }

  public function match( $url )
  {
    // return false if url contains "Action" to prevent bypassing
    // before and after methods
    if ( strpos( $url, "Action" ) ) {
      return false;
    }
    // regular expression for fixed url format controller/action
    foreach ( $this->routes as $route => $params ) {
      if ( preg_match( $route, $url, $matches ) ) {
        // Get named capture group values
        //$params = [];
        foreach ( $matches as $key => $match) {
          if ( is_string( $key ) ) {
            $params[ $key ] = $match;
          }
        }
        $this->params = $params;
        return true;
      }
    }

    return false;

  }

  // Distpatch method of class. Should probably be a class itself
  public function dispatch( $url )
  {
    $url = $this->removeQueryStringVariables( $url );
    $this->resetGETSuperGLobal( $url );

    if ( $this->match( $url ) ) {
        // $root = $this->environment == "production"
        // ? $this->configs[ "routing" ][ $this->environment ][ "root" ]
        // : $this->createRelativeURL( $url );
        // define( "HOME", $this->createRelativeURL( $url ) );
        define( "HOME", $this->configs[ "routing" ][ $this->environment ][ "root" ] );


      // checking to see a a "path" regex variable was created by the router.
      // uses the regex variable "path" to construct the path to the controller
      // and create the namespace under which the controller exists
      $namespace = "Controllers\\";

      if ( !empty( $this->params[ "path" ] ) ) {
        $namespace = $this->buildNamespace( $this->params[ "path" ] );
      }

      $controller = $this->params[ "controller" ];
      #printr( $this->params );
      $controller = $namespace . $this->formatClassName( $controller );

      if ( class_exists( $controller ) ) {

        if ( isset( $this->params[ "action" ] ) ) {
          $method = $this->formatMethodName( $this->params[ "action" ] );
          if ( $method == "" ) {
            $method = "index";
          }

        } else {
          throw new \Exception( "Method \"$method\" is not a method of class $controller", 404 );
        }
        // Magic in use here! ( __call() ) $method is not actually a method of $controller
        // because it's missing the suffix "Action". This allows for before and after
        // action filters. See \Core\Controller::__call();
        return array( "controller" =>  $controller, "method" => $method, "params" => $this->params );

      } else {
        throw new \Exception( "Class \"$controller\" does not exist", 404 );
      }
    } else {
      throw new \Exception( "No route matched", 404 );
    }
  }

  protected function formatClassName( $string )
  {
    return str_replace( ' ', '', ucwords( str_replace( '-', ' ', $string ) ) );
  }

  protected function formatMethodName( $string )
  {
    return lcfirst( $this->formatClassName( $string ) );
  }

  // remove query string variable before matching
  protected function removeQueryStringVariables( $url )
  {
    if ( $url != '' ) {
      $parts = explode('&', $url, 2 );

      if ( strpos( $parts[ 0 ], '=' ) === false ) {
        $url = $parts[ 0 ];
      } else {
        $url = '';
      }
    }
    return $url;
  }

  protected function resetGETSuperGLobal( $url )
  {
      unset( $_GET[ $url ] );
  }

    protected function createRelativeURL( $url )
    {
        $relative_root_ref = "./";
        $depth = ( count( explode( "/", $url ) ) ) - 1;

        if ( $depth > 0 ) {
            $relative_root_ref = str_repeat( "../", $depth );
        }

        return $relative_root_ref;
    }

  private function buildNamespace( $namespace )
  {
    $base_namespace = "Controllers\\";

    $namespace_parts = explode( "/", $this->params[ "path" ] );
    $parts = "";
    $i = 0;
    foreach ( $namespace_parts as $part ) {
      $part = $this->formatClassName( $part ) . "\\";
      $parts .= $part;
    }
    $namespace = $base_namespace . $parts;

    return $namespace;
  }
}
