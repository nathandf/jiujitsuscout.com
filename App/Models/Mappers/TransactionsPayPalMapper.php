<?php
/*
* PayPal Transactions
*/

namespace Models\Mappers;

class TransactionsPayPalStore extends DataMappers
{
  public function getAll()
  {
    return $this->_getAll( "transactions_paypal" );
  }
}
