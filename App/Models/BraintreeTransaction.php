<?php

namespace Models;

class BraintreeTransaction
{
    public $id;
    public $transaction_id;
    public $braintree_transaction_id;
    public $braintree_transaction_status;
    public $braintree_transaction_type;
    public $braintree_transaction_currency_iso_code;
    public $braintree_transaction_amount;
    public $braintree_message;
    public $braintree_merchant_account_id;
    public $braintree_sub_merchant_account_id;
    public $braintree_master_merchant_account_id;
    public $braintree_order_id;
    public $full_transaction_data;
}
