<?php

namespace Model\Services;

class ProductRepository extends Repository
{
    public function getAll()
    {
        $mapper = $this->getMapper();
        $products = $mapper->mapAll();

        return $products;
    }

    public function getByID( $id )
    {
        $mapper = $this->getMapper();
        $product = $mapper->build( $this->entityName );
        $mapper->mapFromID( $product, $id );

        return $product;
    }
}
