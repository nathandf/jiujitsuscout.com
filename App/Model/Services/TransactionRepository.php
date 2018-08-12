<?php

namespace Model\Services;

class TransactionRepository extends Service
{
    public function create( $customer_id, $order_id, $status, $transaction_type, $amount )
    {
        $transaction = new \Model\Transaction();
        $transactionMapper = new \Model\Mappers\TransactionMapper( $this->container );
        $transaction->customer_id = $customer_id;
        $transaction->order_id = $order_id;
        $transaction->status = $status;
        $transaction->transaction_type = $transaction_type;
        $transaction->amount = $amount;

        $transactionMapper->create( $transaction );

        return $transaction;
    }

    public function getAll()
    {
        $transactionMapper = new \Model\Mappers\TransactionMapper( $this->container );
        $transactions = $transactionMapper->mapAll();

        return $transactions;
    }

    public function getByID( $id )
    {
        $transaction = new \Model\Transaction();
        $transactionMapper = new \Model\Mappers\TransactionMapper( $this->container );
        $transactionMapper->mapFromID( $transaction, $id );

        return $transaction;
    }

    public function getByCustomerID( $customer_id )
    {
        $transaction = new \Model\Transaction();
        $transactionMapper = new \Model\Mappers\TransactionMapper( $this->container );
        $transactionMapper->mapFromCustomerID( $transaction, $customer_id );

        return $transaction;
    }
}
