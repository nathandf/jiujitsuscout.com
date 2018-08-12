<?php

namespace Model\Mappers;

use Contracts\DataMapperInterface;

class DataMapperTEMP implements DataMapperInterface
{
    public $DB;
    public $data;
    public $container;

    public function __construct( \Core\DI_Container $container )
    {
        $this->container = $container;
        $this->DB = $this->container->getService( "dao" ); // data access object
    }

    public function insert( $table, array $columns_array, array $values_array )
    {
        $columns_count = count( $columns_array );
        $values_count = count( $values_array );

        // check if the number of values in the values_array is == the number of columns in the columns array
        if ( $columns_count != $values_count ) {
            throw new \Exception( "Number of columns and values does not match.\nColumns ($columns_count) | Values ($values_count)" );
            return false;
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

    public function update( $table, $set_column, $set_column_value, $where_column, $where_column_value )
    {
        $sql = $this->DB->prepare( "UPDATE $table SET $set_column = :set_column_value WHERE $where_column = :where_column_value" );
        $sql->bindParam( ":set_column_value", $set_column_value );
        $sql->bindParam( ":where_column_value", $where_column_value );
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
}
