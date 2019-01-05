<?php

namespace Model\Mappers;

use Contracts\DataMapperInterface;

abstract class DataMapper implements DataMapperInterface
{
    protected $validReturnTypes = [
        "single",
        "array",
        "json",
        "raw"
    ];
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

    public function _insert( array $key_values, $return_object )
    {
        $columns = [];
        $values = [];
        foreach ( $key_values as $column => $value ) {
            $columns[] = $column;
            $values[] = $value;
            $tokens_array[] = ":" . $column;
        }

        $this->validateColumns( $columns);

        $tokens = implode( ",", $tokens_array );
        // TODO Maybe column names should be encapsulated by tic marks
        $columns = implode( ",", $columns );
        $sql = $this->DB->prepare( "INSERT INTO `{$this->getTable()}` ($columns) VALUES ($tokens)" );
        $token_index = 0;

        foreach ( $values as &$value ) {
            $sql->bindParam( $tokens_array[ $token_index ], $value );
            $token_index++;
        }
        
        $sql->execute();

        if ( $return_object ) {
            return $this->get( [ "*" ], [ "id" => $this->DB->lastInsertId() ], "single" );
        }

        return $this->DB->lastInsertId();
    }

    public function get( array $cols_to_get, array $key_values, $return_type )
    {
        $this->validateColsToGet( $cols_to_get );
        $this->validateReturnType( $return_type );

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

        if ( $return_type == "raw" && $cols_to_get != "*" ) {
            $data = [];
            if ( count( $cols_to_get ) > 1 ) {
                while ( $response = $sql->fetch( \PDO::FETCH_ASSOC ) ) {
                    foreach ( $cols_to_get as $col ) {
                        $data[] = $response;
                    }
                }

                return $data;
            }

            while ( $response = $sql->fetch( \PDO::FETCH_ASSOC ) ) {
                $data[] = $response[ $cols_to_get[ 0 ] ];
            }

            return $data;
        }

        while ( $response = $sql->fetch( \PDO::FETCH_ASSOC ) ) {
            $entity = $this->build( $this->formatEntityNameFromTable() );
            $this->populate( $entity, $response );
            $entities[] = $entity;
        }

        switch ( $return_type ) {
            case "single":
                if ( empty( $entities ) ) {
                    return null;
                }
                return $entities[ 0 ];
            case "array":
                return $entities;
            case "json":
                return json_encode( $entities );
        }
    }

    public function update( $table, $set_column, $set_column_value, $where_column, $where_column_value )
    {
        $sql = $this->DB->prepare( "UPDATE $table SET $set_column = :set_column_value WHERE $where_column = :where_column_value" );
        $sql->bindParam( ":set_column_value", $set_column_value );
        $sql->bindParam( ":where_column_value", $where_column_value );
        $sql->execute();
    }

    public function _update( array $columns_to_update, array $where_columns, $validate = true )
    {
        if ( $validate ) {
            $this->validateColumnsFromKeys( $columns_to_update );
            $this->validateColumnsFromKeys( $where_columns );
        }

        $query = "UPDATE " . "`" . $this->getTable() . "`" . " SET " . $this->formatQueryFromKeyValues( $columns_to_update, "0" ) . " WHERE " . $this->formatQueryFromKeyValues( $where_columns, "1" );

        $sql = $this->DB->prepare( $query );

        foreach ( $columns_to_update as $key => &$value ) {
            $token = ":" . "0" . $key;
            $sql->bindParam( $token, $value );
        }

        foreach ( $where_columns as $key => &$value ) {
            $token = ":" . "1" . $key;
            $sql->bindParam( $token, $value );
        }

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

        // Combine with underscores to make table name
        $table = implode( "_", $parts );

        $this->table = strtolower( $table );
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

    private function formatQueryWhere( array $key_values )
    {
        $where_query = "";
        $total = count( $key_values );

        $iteration = 1;
        foreach ( $key_values as $key => $value ) {
            if ( is_null( $value ) || $value === "" ) {
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

    public function formatQueryFromKeyValues( array $key_values, $token_prefix = "" )
    {
        $query = "";
        $total = count( $key_values );

        $i = 1;
        foreach ( $key_values as $key => $value ) {
            if ( is_null( $value ) || $value === "" ) {
                throw new \Exception( "Value cannot be empty: key => {$key}, value = ?" );
            }

            $and = "";
            if ( $i != $total ) {
                $and = " AND ";
            }

            $query = $query . "{$key} = :{$token_prefix}{$key}" . $and;
            $i++;
        }

        return $query;
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

    private function validateColsToGet( $cols_to_get )
    {
        if ( empty( $cols_to_get ) ) {
            throw new \Exception( "cols_to_get array connot be empty" );
        }

        return;
    }

    private function validateReturnType( $return_type )
    {
        if ( !in_array( $return_type, $this->validReturnTypes ) ) {
            throw new \Exception( "{$return_type} is not a valid return type" );

        }
    }

    private function getColumns()
    {
        $table = $this->getTable();
        // $sql = $this->DB->prepare( "SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE table_name = :table" );
        $sql = $this->DB->prepare( "SHOW COLUMNS FROM {$table}" );
        // $sql->bindParam( ":table", $table );
        $sql->execute();

        $columns = [];

        while ( $response = $sql->fetch( \PDO::FETCH_ASSOC ) ) {
            $columns[] = $response[ "Field" ];
        }

        return $columns;
    }

    // Ensure the columns actually exist in the database
    private function validateColumns( array $columns_to_validate )
    {
        $columns = $this->getColumns();

        foreach ( $columns_to_validate as $column ) {
            if ( !in_array( $column, $columns, true ) ) {
                throw new \Exception( "{$column} is not a valid column in table {$this->getTable()}" );
            }
        }

        return;
    }

    private function validateColumnsFromKeys( array $columns_to_validate )
    {
        $column_keys = [];

        foreach ( $columns_to_validate as $key => $value ) {
            $column_keys[] = $key;
        }

        $this->validateColumns( $column_keys );
    }

}
