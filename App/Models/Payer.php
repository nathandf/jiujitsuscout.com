<?php

namespace Models;

class Payer
{

  public function __construct( Account $account )
  {
    $this->account = $account;
  }

  public function setPaymentMethod( $method )
  {
    $this->payment_method = $method
  }

}
