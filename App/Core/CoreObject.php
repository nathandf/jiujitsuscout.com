<?php

namespace Core;

use Contracts\CoreObjectInterface;

abstract class CoreObject implements CoreObjectInterface
{
    protected $container;

    public function setContainer( DI_Container $container )
    {
        $this->container = $container;
    }

    // load allows all children of CoreObject to load in service objects
    // without explicitly referencing the method of retrival. In this case, it's a
    // simple Dependency Injection / IoC Container
    public function load( $service )
    {
        return $this->container->getService( $service );
    }

}
