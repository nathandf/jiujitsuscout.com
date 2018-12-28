<?php

namespace Model\Services;

class TransactionRepository extends Repository
{
    public function create( $customer_id, $order_id, $status, $transaction_type, $amount )
    {
        $mapper = $this->getMapper();
        $transaction = $mapper->build( $this->entityName );
        $transaction->customer_id = $customer_id;
        $transaction->order_id = $order_id;
        $transaction->status = $status;
        $transaction->transaction_type = $transaction_type;
        $transaction->amount = $amount;

        $mapper->create( $transaction );

        return $transaction;
    }

    public function getAll()
    {
        $mapper = $this->getMapper();
        $transactions = $mapper->mapAll();

        return $transactions;
    }

    public function getByID( $id )
    {
        $mapper = $this->getMapper();
        $transaction = $mapper->build( $this->entityName );
        $mapper->mapFromID( $transaction, $id );

        return $transaction;
    }

    public function getByCustomerID( $customer_id )
    {
        $mapper = $this->getMapper();
        $transaction = $mapper->build( $this->entityName );
        $mapper->mapFromCustomerID( $transaction, $customer_id );

        return $transaction;
    }
}
