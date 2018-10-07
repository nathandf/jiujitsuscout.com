<?php

namespace Model\Services;

class BraintreeTransactionRepository extends Service
{
    public function create( $transaction_id, $braintree_transaction_id, $data )
    {
        $braintreeTransaction = new \Model\BraintreeTransaction();
        $braintreeTransactionMapper = new \Model\Mappers\BraintreeTransactionMapper( $this->container );
        $braintreeTransaction->transaction_id = $transaction_id;
        $braintreeTransaction->braintree_transaction_id = $data;
        $braintreeTransaction->data = $data;

        $braintreeTransactionMapper->create( $braintreeTransaction );

        return $braintreeTransaction;
    }

    public function getAll()
    {
        $braintreeTransactionMapper = new \Model\Mappers\BraintreeTransactionMapper( $this->container );
        $braintreeTransactions = $braintreeTransactionMapper->mapAll();

        return $braintreeTransactions;
    }

    public function getByID( $id )
    {
        $braintreeTransaction = new \Model\BraintreeTransaction();
        $braintreeTransactionMapper = new \Model\Mappers\BraintreeTransactionMapper( $this->container );
        $braintreeTransactionMapper->mapFromID( $braintreeTransaction, $id );

        return $braintreeTransaction;
    }

    public function getByTransactionID( $transaction_id )
    {
        $braintreeTransaction = new \Model\BraintreeTransaction();
        $braintreeTransactionMapper = new \Model\Mappers\BraintreeTransactionMapper( $this->container );
        $braintreeTransactionMapper->mapFromTransactionID( $braintreeTransaction, $braintree_transaction_id );

        return $braintreeTransaction;
    }

    public function getByBraintreeTransactionID( $braintree_transaction_id )
    {
        $braintreeTransaction = new \Model\BraintreeTransaction();
        $braintreeTransactionMapper = new \Model\Mappers\BraintreeTransactionMapper( $this->container );
        $braintreeTransactionMapper->mapFromBraintreeTransactionID( $braintreeTransaction, $braintree_transaction_id );

        return $braintreeTransaction;
    }
}
