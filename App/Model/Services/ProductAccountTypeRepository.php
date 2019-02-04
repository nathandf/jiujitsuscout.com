<?php

namespace Model\Services;

use Model\ProductAccountType;
use Model\Mappers\ProductAccountTypeMapper;

class ProductAccountTypeRepository extends Repository
{

    public function getAll()
    {
        $mapper = $this->getMapper();
        $productAccountTypes = $mapper->mapAll();

        return $productAccountTypes;
    }

    public function getByID( $id )
    {
        $mapper = $this->getMapper();
        $productAccountType = $mapper->build( $this->entityName );
        $mapper->mapFromID( $productAccountType, $id );

        return $productAccountType;
    }

    public function getByProductID( $product_id )
    {
        $mapper = $this->getMapper();
        $productAccountType = $mapper->build( $this->entityName );
        $mapper->mapFromProductID( $productAccountType, $product_id );

        return $productAccountType;
    }

}
