<?php

namespace Models\Composites;

class Item
{

  public $id;
  public $product;
  public $name;
  public $price;
  public $currency;
  public $quantity;
  public $discount;
  public $description;

  public function __construct( \Models\Product $product, $quantity )
  {
    $this->product = $product;
    $this->setDescription( $this->product->description );
    $this->setPrice( $this->product->price );
    $this->setQuantity( $quantity );
    $this->setCurrency( $this->product->currency );
    $this->setName( $this->product->name );
  }

  public function setID( $id )
  {
    $this->id = $id;
  }

  public function setDescription( $description )
  {
    if ( isset( $this->product ) ) {
      $this->description = $description;
    }
  }

  public function setCurrency( $currency )
  {
    if ( isset( $this->product ) ) {
      $this->currency = $currency;
    }
  }

  public function setName( $name )
  {
    if ( isset( $this->product ) ) {
      $this->name = $name;
    }
  }

  public function setPrice( $price )
  {
    if ( isset( $this->product ) ) {
      $this->price = $price;
    }
  }

  public function setQuantity( $quantity )
  {
    $this->quantity = $quantity;
  }

}
