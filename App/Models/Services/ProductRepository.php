<?php

namespace Model\Services;

class ProductRepository extends Service
{

  public function getAll()
  {
    $productMapper = new \Model\Mappers\ProductMapper( $this->container );
    $products = $productMapper->mapAll();
    return $products;
  }

  public function getByID( $id )
  {
    $product = new \Model\Product();
    $productMapper = new \Model\Mappers\ProductMapper( $this->container );
    $productMapper->mapFromID( $product, $id );

    return $product;
  }

}
