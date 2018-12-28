<?php

namespace Model\Mappers;

class TransactionMapper extends DataMapper
{

    public function create( \Model\Transaction $transaction )
    {
        $now = time();
        $id = $this->insert(
            "transaction",
            [
                "customer_id",
                "order_id",
                "status",
                "transaction_type",
                "amount",
                "created_at",
                "updated_at",
            ],
            [
                $transaction->customer_id,
                $transaction->order_id,
                $transaction->status,
                $transaction->transaction_type,
                $transaction->amount,
                $now,
                $now
            ]
        );

        $transaction->created_at = $now;
        $transaction->updaged_at = $now;
        $transaction->id = $id;

        return $transaction;
    }

    public function mapAll()
    {
        
        $transactions = [];
        $sql = $this->DB->prepare( "SELECT * FROM transaction" );
        $sql->execute();
        while ( $resp = $sql->fetch( \PDO::FETCH_ASSOC ) ) {
            $transaction = $this->entityFactory->build( "Transaction" );
            $this->populateTransaction( $transaction, $resp );
            $transactions[] = $transaction;
        }

        return $transactions;
    }

    public function mapFromID( \Model\Transaction $transaction, $id )
    {
        $sql = $this->DB->prepare( "SELECT * FROM transaction WHERE id = :id" );
        $sql->bindParam( ":id", $id );
        $sql->execute();
        $resp = $sql->fetch( \PDO::FETCH_ASSOC );
        $this->populateTransaction( $transaction, $resp );

        return $transaction;
    }

    public function mapFromCustomerID( \Model\Transaction $transaction, $customer_id )
    {
        $sql = $this->DB->prepare( "SELECT * FROM transaction WHERE customer_id = :customer_id" );
        $sql->bindParam( ":customer_id", $customer_id );
        $sql->execute();
        $resp = $sql->fetch( \PDO::FETCH_ASSOC );
        $this->populateTransaction( $transaction, $resp );

        return $transaction;
    }

    private function populateTransaction( \Model\Transaction $transaction, $data )
    {
        $transaction->id          = $data[ "id" ];
        $transaction->customer_id = $data[ "customer_id" ];
        $transaction->order_id    = $data[ "order_id" ];
        $transaction->status      = $data[ "status" ];
        $transaction->transaction = $data[ "transaction_type" ];
        $transaction->amount      = $data[ "amount" ];
        $transaction->created_at  = $data[ "created_at" ];
        $transaction->updated_at  = $data[ "updated_at" ];
    }

}
