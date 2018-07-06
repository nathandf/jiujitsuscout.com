<?php

namespace Models\Composites;

class Amount
{

  public $details;
  public $total;
  public $currency;

  public function __construct( \Models\Composites\TransactionDetails $details )
  {
    $this->details = $details;
    $this->setTotal();
  }

  public function setTotal( )
  {
    $this->total = $this->details->sub_total - $this->details->discount;
  }

  public function getTotal()
  {
    return $this->total;
  }

  // ISO code
  public function setCurrency( $currency )
  {
    $this->currency = $currency;
  }

  public function getCurrency()
  {
    return $this->currency;
  }

}
