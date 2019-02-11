<?php

namespace Model\Services;

class BraintreeTransactionRepository extends Repository
{
    public function create( $transaction_id, $braintree_transaction_id, $data )
    {
        $mapper = $this->getMapper();
        $braintreeTransaction = $mapper->build( $this->entityName );
        $braintreeTransaction->transaction_id = $transaction_id;
        $braintreeTransaction->braintree_transaction_id = $data;
        $braintreeTransaction->data = $data;

        $mapper->create( $braintreeTransaction );

        return $braintreeTransaction;
    }

    public function getAll()
    {
        $mapper = $this->getMapper();
        $braintreeTransactions = $mapper->mapAll();

        return $braintreeTransactions;
    }

    public function getByID( $id )
    {
        $mapper = $this->getMapper();
        $braintreeTransaction = $mapper->build( $this->entityName );
        $mapper->mapFromID( $braintreeTransaction, $id );

        return $braintreeTransaction;
    }

    public function getByTransactionID( $transaction_id )
    {
        $mapper = $this->getMapper();
        $braintreeTransaction = $mapper->build( $this->entityName );
        $mapper->mapFromTransactionID( $braintreeTransaction, $braintree_transaction_id );

        return $braintreeTransaction;
    }

    public function getByBraintreeTransactionID( $braintree_transaction_id )
    {
        $mapper = $this->getMapper();
        $braintreeTransaction = $mapper->build( $this->entityName );
        $mapper->mapFromBraintreeTransactionID( $braintreeTransaction, $braintree_transaction_id );

        return $braintreeTransaction;
    }
}
