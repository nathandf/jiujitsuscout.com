<?php

namespace Models\Services;

class ProductRepository extends Service
{

  public function getAll()
  {
    $productMapper = new \Models\Mappers\ProductMapper( $this->container );
    $products = $productMapper->mapAll();
    return $products;
  }

  public function getByID( $id )
  {
    $product = new \Models\Product();
    $productMapper = new \Models\Mappers\ProductMapper( $this->container );
    $productMapper->mapFromID( $product, $id );

    return $product;
  }

}
