<?php

namespace Models\Composites;

class Payment
{

  public function __construct( Transaction $transaction, Payer $payer )
  {
    $this->$transaction = $transaction;
    $this->$payer = $payer;
  }

}
