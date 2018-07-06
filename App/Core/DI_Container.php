<?php
/*
* Dependency Injector
*/
namespace Core;

class DI_Container
{
  protected $services = [];

  public function register( $service_name, callable $service )
  {
    $this->services[ $service_name ] = $service;
  }

  public function getService( $service_name )
  {
    // Check if a service by this name exisits.
    if ( !array_key_exists( $service_name, $this->services ) ) {
      throw new \Exception( "Service '{$service_name}' cannot be found." );
    }

    // Returning existing service
    return $this->services[ $service_name ]();
  }

  public function listServices()
  {
    if ( empty( $this->services ) ) {
      throw new \Exception( "No services are registered with the DI_Container" );
    }
    return array_keys( $this->services );
  }
}
