<?php

namespace Model\Services;

use Model\Services\BraintreeGatewayInitializer;

class BraintreeAPIManager
{
    // Gateway object for interfacing with braintree payments API
    public $gateway;

    // Flag for storing payment method in braintree vault on success
    public $storeInVaultOnSuccess = false;

    // Braintree customer
    public $customer = false;

    // Braintree customer's payment method
    public $paymentMethods;

    // Payment method token to be used
    public $pyamentMethodToken;

    // Braintree sale result
    public $transactionResponseObject = false;

    // Subscription result
    public $subscriptionResults = false;

    public function __construct( BraintreeGatewayInitializer $gateway )
    {
        // Initialize connection with braintree API
        $this->gateway = $gateway->init();
    }

    private function customerExists( $customer_id )
    {
        $collection = $this->gateway->customer()->search([
            \Braintree_CustomerSearch::id()->is( $customer_id )
        ]);

        foreach ( $collection as $customer ) {
            if ( $customer->id == $customer_id ) {
                return true;
            }
        }

        return false;
    }

    public function getOrCreateCustomerByPaymentMethodNonce( $customer_id, $paymentMethodNonce, $customer_details = [] )
    {
        // Search braintree account for a customer with provided id. If a
        // customer exists, request for the customer object and return it. If
        // a customer doesn't exists, create a new one with provided details
        if ( $this->customerExists( $customer_id ) ) {
            try {
                $customer = $this->gateway->customer()->find( $customer_id );
            } catch ( \Exception $e ) {
                //
            }
        } else {
            $customer = $this->createCustomerByPaymentMethodNonce(
                $paymentMethodNonce,
                [
                    "id" => $customer_id,
                    "first_name" => $customer_details[ "first_name" ],
                    "last_name" => $customer_details[ "last_name" ],
                    "email" => $customer_details[ "email" ],
                    "phone" => $customer_details[ "phone" ]
                ]
            );

            // Set flag to trigger storage of the new customer's payement method
            // in the vault
            $this->storeInVaultOnSuccess = true;
        }

        $this->setCustomer( $customer );
        $this->setPaymentMethods( $customer->paymentMethods );
        $this->setPaymentMethodToken( $customer->paymentMethods[ 0 ]->token );

        return $customer;
    }

    public function createCustomerByPaymentMethodNonce( $paymentMethodNonce, $customer_details = [] )
    {
        $result = $this->gateway->customer()->create([
            "id" => $customer_details[ "id" ],
            "firstName" => $customer_details[ "first_name" ],
            "lastName" => $customer_details[ "last_name" ],
            "email" => $customer_details[ "email" ],
            "phone" => $customer_details[ "phone" ],
            "paymentMethodNonce" => $paymentMethodNonce
        ]);

        if ( !$result->success ) {
            throw new \Exception( "Could not create new customer" );
        }

        return $result->customer;
    }

    public function setCustomer( $customer )
    {
        $this->customer = $customer;
    }

    public function processTransaction( $transactionTotal )
    {
        if ( !$this->customer ) {
            return false;
        }
        // Process payment as normal using customer id
        $result = $this->gateway->transaction()->sale( [
            "amount" => $transactionTotal,
            "customerId" => $this->customer->id,
            "options" => [
                "submitForSettlement" => true,
                'storeInVaultOnSuccess' => $this->storeInVaultOnSuccess
            ]
        ] );

        $this->setTransactionResponseObject( $result );

        return true;
    }

    public function setTransactionResponseObject( $result )
    {
        $this->transactionResponseObject = $result;
    }

    public function getTransactionResponseObject()
    {
        if ( isset( $this->transactionResponseObject ) ) {
            return $this->transactionResponseObject;
        }

        return null;
    }

    public function createSubscription( $plan_id, $paymentMethodToken, $price = null, $startImmediately = false )
    {
        // Build subscription request array.
        $subscriptionRequest = [
            "paymentMethodToken" => $paymentMethodToken,
            "planId" => $plan_id
        ];

        // If start immediate is not specified, then start this day next month
        if ( $startImmediately ) {
            $subscriptionRequest[ "startImmediately" ] = true;
        } else {
            // Create a datetime object representing the same date next month
            // This object will be used to specify the first billing date
            $num_of_days = cal_days_in_month( CAL_GREGORIAN, date( "m" ), date( "Y" ) );
            $modifier = "now + " . $num_of_days . " days";
            $next_month = new \DateTime( $modifier );
            $next_month->setTime( 0, 0, 0 );

            $subscriptionRequest[ "firstBillingDate" ] = $next_month;
        }

        // Add the subscription price to the subscriptionRequest array if specified
        if ( !is_null( $price ) ) {
            $subscriptionRequest[ "price" ] = $price;
        }

        $subscriptionResult = $this->gateway->subscription()->create( $subscriptionRequest );

        $this->setSubscriptionResult( $subscriptionResult );

        if ( !$subscriptionResult->success ) {
            return false;
        }

        return true;
    }

    public function setSubscriptionResult( $result )
    {
        $this->subscriptionResult = $result;
    }

    public function getSubscriptionResult()
    {
        if ( $this->subscriptionResult !== false ) {
            return $this->subscriptionResult;
        }
    }

    public function setPaymentMethods( $paymentMethods )
    {
        $this->paymentMethods = $paymentMethods;
    }

    public function getPaymentMethods()
    {
        if ( isset( $this->paymentMethods ) ) {
            return $this->paymentMethods;
        }

        return null;
    }

    public function setPaymentMethodToken( $paymentMethodToken )
    {
        $this->paymentMethodToken = $paymentMethodToken;
    }

    public function getPaymentMethodToken()
    {
        if ( isset( $this->paymentMethodToken ) ) {
            return $this->paymentMethodToken;
        }

        return null;
    }
}
