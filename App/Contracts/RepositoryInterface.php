<?php

namespace Contracts;

interface RepositoryInterface
{
	public function insert( array $key_values );
	public function get( array $columns );
	public function update( array $columns_to_update, array $where_columns );
	public function delete( array $keys, array $values );
}
