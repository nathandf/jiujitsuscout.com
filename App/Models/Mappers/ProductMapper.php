<?php

namespace Model\Mappers;

class ProductMapper extends DataMapper
{

  public function mapAll()
  {
    $entityFactory = $this->container->getService( "entity-factory" );
    $products = [];
    $sql = $this->DB->prepare( "SELECT * FROM product" );
    $sql->execute();
    while ( $resp = $sql->fetch( \PDO::FETCH_ASSOC ) ) {
      $product = $entityFactory->build( "Product" );
      $this->populateProduct( $product, $resp );
      $products[] = $product;
    }

    return $products;
  }

  public function mapFromID( \Model\Product $product, $id )
  {
    $sql = $this->DB->prepare( "SELECT * FROM product WHERE id = :id" );
    $sql->bindParam( ":id", $id );
    $sql->execute();
    $resp = $sql->fetch( \PDO::FETCH_ASSOC );
    $this->populateProduct( $product, $resp );
    return $product;
  }

  private function populateProduct( \Model\Product $product, $data )
  {
    $product->id                = $data[ "id" ];
    $product->product_type_id   = $data[ "product_type_id" ];
    $product->price             = $data[ "price" ];
    $product->currency          = $data[ "currency" ];
    $product->name              = $data[ "name" ];
    $product->description       = $data[ "description" ];
  }

}
