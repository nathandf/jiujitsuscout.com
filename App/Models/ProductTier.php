<?php

namespace Model;

use Contracts\EntityInterface;

class ProductTier implements EntityInterface
{

  public $id;
  public $product_id;
  public $price;
  public $currency;
  public $name;
  public $description;

}
