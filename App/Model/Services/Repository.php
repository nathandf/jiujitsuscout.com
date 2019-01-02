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
        if ( isset( $this->mapper ) == false ) {
            throw new \Exception( "'Mapper' is not set" );
        }

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

    // Basic CRUD
    public function insert( array $columns, array $values )
    {
        $mapper = $this->getMapper();
        $entity = $mapper->build( $this->entityName );

        $mapper->_insert( $columns, $values );
    }

    public function get( array $columns, $key_values = [], $return_type = "array" )
    {
        if ( !is_array( $key_values ) ) {
            throw new \Exception( "key_values argument must be an array" );
        }

        if ( func_num_args() > 2 ) {
            $return_type = func_get_args()[ 2 ];
        }

        $mapper = $this->getMapper();
        $result = $mapper->get( $columns, $key_values, $return_type );

        return $result;
    }

    public function update( array $columns_to_update, array $where_columns )
    {
        $mapper = $this->getMapper();
        $mapper->_update( $columns_to_update, $where_columns );
    }

    public function delete( array $keys, array $values )
    {
        $mapper = $this->getMapper();
        $mapper->delete( $keys, $values );
    }
}
