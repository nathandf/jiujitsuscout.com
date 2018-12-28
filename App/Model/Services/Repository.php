<?php

namespace Model\Services;

use Core\DI_Container;
use Model\Mappers\DataMapper;

abstract class Repository
{
    protected $entityName;
    protected $mapper;
    protected $mapperNamespace;

    public function __construct( $dao, $entityFactory )
    {
        $this->buildEntityName();
        $this->setMapperNamespace( "\Model\Mappers\\" );

        $this->setMapper(
            $this->buildMapper( $dao, $entityFactory )
        );
    }

    protected function setMapper( DataMapper $mapper )
    {
        $this->mapper = $mapper;
    }

    protected function getMapper()
    {
        return $this->mapper;
    }

    protected function buildMapper( $dao, $entityFactory )
    {
        $mapperName = $this->buildMapperName();

        $mapper = new $mapperName( $dao, $entityFactory );

        return $mapper;
    }

    protected function buildEntityName()
    {
        // Derive the name of the mapper and entity from the class name of this repository
        $repositoryClassName = explode( "\\", get_class( $this ) );
        $entityName = $this->mapperNamespace . str_replace( "Repository", "", end( $repositoryClassName ) );

        // Set entity name
        $this->setEntityName( $entityName );
    }

    protected function buildMapperName()
    {
        return $this->mapperNamespace . $this->entityName . "Mapper";
    }

    protected function setEntityName( $entityName )
    {
        $this->entityName = $entityName;
    }

    protected function setMapperNamespace( $namespace )
    {
        $this->mapperNamespace = $namespace;
    }
}
