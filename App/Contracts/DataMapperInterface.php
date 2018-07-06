<?php

namespace Contracts;

interface DataMapperInterface
{
  public function insert( $table, array $columns_array, array $values_array );
  public function update( $table, $set_column, $set_column_value, $where_column, $where_column_value );
  public function getAll( $table );
  public function getAllWhere( $table, $key, $value );
}
