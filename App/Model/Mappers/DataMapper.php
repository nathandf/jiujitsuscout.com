<?php

namespace Model\Mappers;

use Contracts\DataMapperInterface;

abstract class DataMapper implements DataMapperInterface
{
    protected $DB;
    protected $table;
    public $entityFactory;

    public function __construct( $dao, \Model\Services\EntityFactory $entityFactory )
    {
        $this->DB = $dao;
        $this->entityFactory = $entityFactory;
        $this->setTable();
    }

    public function insert( $table, array $columns_array, array $values_array )
    {
        $columns_count = count( $columns_array );
        $values_count = count( $values_array );

        // check if the number of values in the values_array is == the number of columns in the columns array
        if ( $columns_count != $values_count ) {
            throw new \Exception( "Number of columns and values does not match.\nColumns ($columns_count) | Values ($values_count)" );
        }

        foreach ( $columns_array as $column ) {
            $tokens_array[] = ":" . $column;
        }

        $tokens = implode( ",", $tokens_array );
        $columns = implode( ",", $columns_array );
        $sql = $this->DB->prepare( "INSERT INTO $table ($columns) VALUES ($tokens)" );
        $token_index = 0;

        foreach ( $values_array as &$value ) {
            $sql->bindParam( $tokens_array[ $token_index ], $value );
            $token_index++;
        }
        $sql->execute();

        return $this->DB->lastInsertId();
    }

    public function _insert( array $columns, array $values, $return_object = true )
    {
        $id = $this->insert( $this->table, $columns, $values );

        if ( $return_object ) {
            return $this->get( [ "*" ], [ "id" => $id ] );
        }

        return $id;
    }

    public function get( array $cols_to_get, array $key_values )
    {
        if ( empty( $cols_to_get ) ) {
            throw new \Exception( "cols_to_get array connot be empty" );
        }

        $table = $this->getTable();
        $query = "SELECT ";
        $columns_query = $this->formatQueryColumns( $cols_to_get );
        $where_query = $this->formatQueryWhere( $key_values );

        $query = $query . $columns_query . " FROM " . "`" . $table . "`" . $where_query;

        $sql = $this->DB->prepare( $query );

        // Bind parameters in where query. The token will the name of the key
        // preceded by a colon.
        foreach ( $key_values as $key => &$value ) {
            $token = ":" . $key;
            $sql->bindParam( $token, $value );
        }

        $sql->execute();

        $entities = [];
        while ( $response = $sql->fetch( \PDO::FETCH_ASSOC ) ) {
            $entity = $this->build( $this->formatEntityNameFromTable() );
            $this->populate( $entity, $response );
            $entities[] = $entity;
        }

        // If more query returns more than 1 row, return an array of objects. if
        // only 1, return just the object itself
        $entity_count = count( $entities );
        if ( empty( $entities ) || $entity_count > 1 ) {
            return $entities;
        }

        return $entities[ 0 ];
    }

    public function update( $table, $set_column, $set_column_value, $where_column, $where_column_value )
    {
        $sql = $this->DB->prepare( "UPDATE $table SET $set_column = :set_column_value WHERE $where_column = :where_column_value" );
        $sql->bindParam( ":set_column_value", $set_column_value );
        $sql->bindParam( ":where_column_value", $where_column_value );
        $sql->execute();
    }

    public function delete( array $keys, array $values )
    {
        if ( empty( $keys ) || empty( $values ) ) {
            throw new \Exception( "Keys and values arrays connot be empty" );
        }

        if ( count( $keys ) != count( $values ) ) {
            throw new \Exception( "The number of keys and values does not match" );
        }

        $table = $this->getTable();
        $query = "DELETE FROM " . "`" . $table . "`" . $this->formatQueryWhereKeyValuePairs( $keys, $values );

        $sql = $this->DB->prepare( $query );

        // Bind parameters in where query. The token will the name of the key
        // preceded by a colon.
        $key_values = array_combine( $keys, $values );
        foreach ( $key_values as $key => &$value ) {
            $token = ":" . $key;
            $sql->bindParam( $token, $value );
        }

        $sql->execute();
    }

    public function getAllWhere( $table, $key, $value )
    {
        $sql = $this->DB->prepare( "SELECT * FROM $table WHERE $key = :value" );
        $sql->bindParam( ":value", $value );
        $sql->execute();
        $resp = $sql->fetch( \PDO::FETCH_ASSOC );

        return $resp;
    }

    public function getAll( $table )
    {
        $data = [];
        $sql = $this->DB->prepare( "SELECT * FROM $table" );
        $sql->execute();

        while ( $row = $sql->fetch( \PDO::FETCH_ASSOC ) ) {
            $data[] = $row;
        }

        return $data;
    }

    public function build( $class_name )
    {
        return $this->entityFactory->build( $class_name );
    }

    protected function populate( $entity, $data )
    {
        if ( !is_object( $entity ) ) {
            throw new \Exception( "Argument 'entity' must be an object" );
        }

        if ( $data ) {
            foreach ( $data as $key => $d ) {
                $entity->{$key} = $data[ $key ];
            }
        }
    }

    public function setTable()
    {
        // Derive table name from mapper name
        $class_name = str_replace( "Mapper", "", str_replace( __NAMESPACE__ . "\\", "", get_class( $this ) ) );

        // Split the class name at the upper case letters
        $parts = preg_split( "/(?=[A-Z])/", lcfirst( $class_name ) );

        // Make all strings lowercase
        foreach ( $parts as $part ) {
            $part = strtolower( $part );
        }

        // Combine with underscores to make table name
        $table = implode( "_", $parts );

        $this->table = $table;
    }

    public function getTable()
    {
        return $this->table;
    }

    protected function formatEntityNameFromTable()
    {
        $parts = explode( "_", $this->getTable() );

        foreach ( $parts as $part ) {
            $part = ucfirst( $part );
        }

        return implode( "", $parts );
    }


    protected function formatQueryColumns( array $columns )
    {
        return implode( ", ", $columns );
    }

    protected function formatQueryWhere( array $key_values )
    {
        $where_query = "";
        $total = count( $key_values );

        $iteration = 1;
        foreach ( $key_values as $key => $value ) {
            if ( is_null( $value ) || $value == "" ) {
                throw new \Exception( "Value cannot be empty: key => {$key}, value = ?" );
            }

            if ( $iteration == 1 && !empty( $key_values ) ) {
                $where_query = " WHERE ";
            }
            $and = "";
            if ( $iteration != $total ) {
                $and = " AND ";
            }

            $where_query = $where_query . "{$key} = :{$key}" . $and;
            $iteration++;
        }

        return $where_query;
    }

    public function formatQueryWhereKeyValuePairs( array $keys, array $values )
    {
        // Make sure no keys or values are empty
        foreach ( $keys as $key ) {
            if ( empty( $key ) || $key = "" || is_array( $key ) ) {
                throw new \Exception( "Key must be a non-empty string" );
            }
        }
        foreach ( $values as $value ) {
            if ( empty( $value ) || $value = "" || is_array( $value ) ) {
                throw new \Exception( "Value must be a non-empty string" );
            }
        }

        $key_values = array_combine( $keys, $values );

        return $this->formatQueryWhere( $key_values );
    }
}
