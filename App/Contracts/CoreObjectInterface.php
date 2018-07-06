<?php

namespace Contracts;

interface CoreObjectInterface
{
    public function setContainer( \Core\DI_Container $container );
    public function load( $service );
}
