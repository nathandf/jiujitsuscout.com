<?php

namespace Models\Mappers;

class BraintreeTransactionMapper extends DataMapper
{

    public function create( \Models\BraintreeTransaction $braintreeTransaction )
    {
        $now = time();
        $id = $this->insert(
            "braintree_transaction",
            [
                "braintree_transaction_id",
                "braintree_transaction_status",
                "braintree_transaction_type",
                "braintree_transaction_currency_iso_code",
                "braintree_transaction_amount",
                "braintree_message",
                "braintree_merchant_account_id",
                "braintree_sub_merchant_account_id",
                "braintree_master_merchant_account_id",
                "braintree_order_id",
                "braintree_processor_response_code",
                "full_transaction_data"
            ],
            [
                $braintreeTransaction->braintree_transaction_id,
                $braintreeTransaction->braintree_transaction_status,
                $braintreeTransaction->braintree_transaction_type,
                $braintreeTransaction->braintree_transaction_currency_iso_code,
                $braintreeTransaction->braintree_transaction_amount,
                $braintreeTransaction->braintree_message,
                $braintreeTransaction->braintree_merchant_account_id,
                $braintreeTransaction->braintree_sub_merchant_account_id,
                $braintreeTransaction->braintree_master_merchant_account_id,
                $braintreeTransaction->braintree_order_id,
                $braintreeTransaction->braintree_processor_response_code,
                $braintreeTransaction->full_transaction_data
            ]
        );

        $braintreeTransaction->id = $id;

        return $braintreeTransaction;
    }

    public function mapAll()
    {
        $entityFactory = $this->container->getService( "entity-factory" );
        $braintreeTransactions = [];
        $sql = $this->DB->prepare( "SELECT * FROM braintree_transaction" );
        $sql->execute();
        while ( $resp = $sql->fetch( \PDO::FETCH_ASSOC ) ) {
            $braintreeTransaction = $entityFactory->build( "BraintreeTransaction" );
            $this->populateBraintreeTransaction( $braintreeTransaction, $resp );
            $braintreeTransactions[] = $braintreeTransaction;
        }

        return $braintreeTransactions;
    }

    public function mapFromID( \Models\BraintreeTransaction $braintreeTransaction, $id )
    {
        $sql = $this->DB->prepare( "SELECT * FROM braintree_transaction WHERE id = :id" );
        $sql->bindParam( ":id", $id );
        $sql->execute();
        $resp = $sql->fetch( \PDO::FETCH_ASSOC );
        $this->populateBraintreeTransaction( $braintreeTransaction, $resp );

        return $braintreeTransaction;
    }

    public function mapFromBraintreeTransactionID( \Models\BraintreeTransaction $braintreeTransaction, $braintree_transaction_id )
    {
        $sql = $this->DB->prepare( "SELECT * FROM braintree_transaction WHERE braintree_transaction_id = :braintree_transaction_id" );
        $sql->bindParam( ":braintree_transaction_id", $braintree_transaction_id );
        $sql->execute();
        $resp = $sql->fetch( \PDO::FETCH_ASSOC );
        $this->populateBraintreeTransaction( $braintreeTransaction, $resp );

        return $braintreeTransaction;
    }

    private function populateBraintreeTransaction( \Models\BraintreeTransaction $braintreeTransaction, $data )
    {
        $braintreeTransaction->id                                   = $data[ "id" ];
        $braintreeTransaction->braintree_transaction_id             = $data[ "braintree_transaction_id" ];
        $braintreeTransaction->braintree_transaction_status         = $data[ "braintree_transaction_status" ];
        $braintreeTransaction->braintree_transaction_type           = $data[ "braintree_type" ];
        $braintreeTransaction->braintree_transaction_currency       = $data[ "braintree_currency" ];
        $braintreeTransaction->braintree_transaction_amount         = $data[ "braintree_amount" ];
        $braintreeTransaction->braintree_message                    = $data[ "braintree_message" ];
        $braintreeTransaction->braintree_merchant_account_id        = $data[ "braintree_merchant_account_id" ];
        $braintreeTransaction->braintree_sub_merchant_account_id    = $data[ "braintree_sub_merchant_account_id" ];
        $braintreeTransaction->braintree_master_merchant_account_id = $data[ "braintree_master_merchant_account_id" ];
        $braintreeTransaction->braintree_order_id                   = $data[ "braintree_order_id" ];
        $braintreeTransaction->braintree_processor_response_code    = $data[ "braintree_processor_response_code" ];
        $braintreeTransaction->full_transaction_data                = $data[ "full_transaction_data" ];
    }

}
