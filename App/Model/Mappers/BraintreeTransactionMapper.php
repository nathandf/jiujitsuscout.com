<?php

namespace Model\Mappers;

class BraintreeTransactionMapper extends DataMapper
{

    public function create( \Model\BraintreeTransaction $braintreeTransaction )
    {
        $now = time();
        $id = $this->insert(
            "braintree_transaction",
            [
                "transaction_id",
                "braintree_transaction_status",
                "data",
            ],
            [
                $braintreeTransaction->braintree_transaction_id,
                $braintreeTransaction->transaction_id,
                $braintreeTransaction->data
            ]
        );

        $braintreeTransaction->id = $id;

        return $braintreeTransaction;
    }

    public function mapAll()
    {
        
        $braintreeTransactions = [];
        $sql = $this->DB->prepare( "SELECT * FROM braintree_transaction" );
        $sql->execute();
        while ( $resp = $sql->fetch( \PDO::FETCH_ASSOC ) ) {
            $braintreeTransaction = $this->entityFactory->build( "BraintreeTransaction" );
            $this->populateBraintreeTransaction( $braintreeTransaction, $resp );
            $braintreeTransactions[] = $braintreeTransaction;
        }

        return $braintreeTransactions;
    }

    public function mapFromID( \Model\BraintreeTransaction $braintreeTransaction, $id )
    {
        $sql = $this->DB->prepare( "SELECT * FROM braintree_transaction WHERE id = :id" );
        $sql->bindParam( ":id", $id );
        $sql->execute();
        $resp = $sql->fetch( \PDO::FETCH_ASSOC );
        $this->populateBraintreeTransaction( $braintreeTransaction, $resp );

        return $braintreeTransaction;
    }

    public function mapFromTransactionID( \Model\BraintreeTransaction $braintreeTransaction, $transaction_id )
    {
        $sql = $this->DB->prepare( "SELECT * FROM braintree_transaction WHERE transaction_id = :transaction_id" );
        $sql->bindParam( ":transaction_id", $transaction_id );
        $sql->execute();
        $resp = $sql->fetch( \PDO::FETCH_ASSOC );
        $this->populateBraintreeTransaction( $braintreeTransaction, $resp );

        return $braintreeTransaction;
    }

    public function mapFromBraintreeTransactionID( \Model\BraintreeTransaction $braintreeTransaction, $braintree_transaction_id )
    {
        $sql = $this->DB->prepare( "SELECT * FROM braintree_transaction WHERE braintree_transaction_id = :braintree_transaction_id" );
        $sql->bindParam( ":braintree_transaction_id", $braintree_transaction_id );
        $sql->execute();
        $resp = $sql->fetch( \PDO::FETCH_ASSOC );
        $this->populateBraintreeTransaction( $braintreeTransaction, $resp );

        return $braintreeTransaction;
    }

    private function populateBraintreeTransaction( \Model\BraintreeTransaction $braintreeTransaction, $data )
    {
        $braintreeTransaction->id                                   = $data[ "id" ];
        $braintreeTransaction->transaction_id                       = $data[ "transaction_id" ];
        $braintreeTransaction->braintree_transaction_id             = $data[ "braintree_transaction_id" ];
        $braintreeTransaction->data                                 = $data[ "data" ];
    }

}
