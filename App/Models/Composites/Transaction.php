<?php

namespace Models\Composites;

class Transaction
{

  public $itemList;
  public $details;
  public $amount;
  public $description;

  public function __construct( \Models\Composites\ItemList $itemList, \Models\Composites\TransactionDetails $details, \Models\Composites\Amount $amount )
  {
    $this->itemList = $itemList;
    $this->amount = $amount;
    $this->details = $details;
  }

  public function setDescription( $description )
  {
    $this->description = $description;
  }

  public function getDescription()
  {
    return $this->description;
  }

}
