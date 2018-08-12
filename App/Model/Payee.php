<?php

namespace Model;

class Payee
{

  public function __construct( Account $account )
  {
    $this->account = $account;
  }

}
