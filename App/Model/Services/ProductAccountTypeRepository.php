<?php

namespace Model\Services;

use Model\ProductAccountType;
use Model\Mappers\ProductAccountTypeMapper;

class ProductAccountTypeRepository extends Service
{

    public function getAll()
    {
        $productAccountTypeMapper = new ProductAccountTypeMapper( $this->container );
        $productAccountTypes = $productAccountTypeMapper->mapAll();

        return $productAccountTypes;
    }

    public function getByID( $id )
    {
        $productAccountType = new ProductAccountType();
        $productAccountTypeMapper = new ProductAccountTypeMapper( $this->container );
        $productAccountTypeMapper->mapFromID( $productAccountType, $id );

        return $productAccountType;
    }

    public function getByProductID( $product_id )
    {
        $productAccountType = new ProductAccountType();
        $productAccountTypeMapper = new ProductAccountTypeMapper( $this->container );
        $productAccountTypeMapper->mapFromProductID( $productAccountType, $product_id );
        return $productAccountType;
    }

}
