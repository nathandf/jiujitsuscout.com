<?php

namespace Models\Services;

use Core\DI_Container;
use Models\Mappers\DataMapper;

abstract class Service
{

  protected $container;
  protected $mapper;

  public function __construct( DI_Container $container )
  {
    $this->container = $container;
  }

  protected function setMapper( DataMapper $mapper )
  {
    $this->mapper = $mapper;
  }

  protected function getMapper()
  {
    return $this->mapper;
  }

}
