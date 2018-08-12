<?php

namespace Model\Services;

class BraintreeTransactionRepository extends Service
{
    public function create( array $braintree_transaction_data )
    {
        $braintreeTransaction = new \Model\BraintreeTransaction();
        $braintreeTransactionMapper = new \Model\Mappers\BraintreeTransactionMapper( $this->container );
        $braintreeTransaction->braintree_transaction_id = $braintree_transaction_data[ "transaction_id" ];
        $braintreeTransaction->braintree_transaction_status = $braintree_transaction_data[ "transaction_status" ];
        $braintreeTransaction->braintree_transaction_type = $braintree_transaction_data[ "transaction_type" ];
        $braintreeTransaction->braintree_transaction_currency_iso_code = $braintree_transaction_data[ "transaction_currency_iso_code" ];
        $braintreeTransaction->braintree_transaction_amount = $braintree_transaction_data[ "transaction_amount" ];
        $braintreeTransaction->braintree_message = $braintree_transaction_data[ "message" ];
        $braintreeTransaction->braintree_merchant_account_id = $braintree_transaction_data[ "merchant_account_id" ];
        $braintreeTransaction->braintree_sub_merchant_account_id = $braintree_transaction_data[ "sub_merchant_account_id" ];
        $braintreeTransaction->braintree_master_merchant_account_id = $braintree_transaction_data[ "master_merchant_account_id" ];
        $braintreeTransaction->braintree_processor_response_code = $braintree_transaction_data[ "processor_response_code" ];
        $braintreeTransaction->braintree_order_id = $braintree_transaction_data[ "order_id" ];
        $braintreeTransaction->full_transaction_data = $braintree_transaction_data[ "full_transaction_data" ];

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

    public function getByBraintreeTransactionID( $braintree_transaction_id )
    {
        $braintreeTransaction = new \Model\BraintreeTransaction();
        $braintreeTransactionMapper = new \Model\Mappers\BraintreeTransactionMapper( $this->container );
        $braintreeTransactionMapper->mapFromBraintreeTransactionID( $braintreeTransaction, $braintree_transaction_id );

        return $braintreeTransaction;
    }
}
