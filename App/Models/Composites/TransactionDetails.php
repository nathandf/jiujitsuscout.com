<?php

namespace Models\Composites;

class TransactionDetails
{

  public $sub_total;
  public $discount;

  public function setSubTotal( $sub_total )
  {
    $this->sub_total = $sub_total;
  }

  public function setDiscount( $discount )
  {
    $this->discount = $discount;
  }

}
