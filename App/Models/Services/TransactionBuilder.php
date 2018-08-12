<?php

namespace Models\Services;

class TransactionBuilder
{
    // Customer order
    public $order;
    // orderProducts related to customer order;
    public $orderProducts;
    // Transaction Total default
    public $transaction_total = 0;
    // Flag for subscription
    public $hasSubscription = false;
    // Transaction currency symbol - Default: $
    public $currency_symbol = "$";
    // Subscription orderProducts
    public $subscriptionOrderProducts = [];
    // Default post-payment redirect url
    public $payment_redirect_url;

    public function __construct( \Models\Services\TransactionRepository $transactionRepo, \Models\Services\OrderRepository $orderRepo, \Models\Services\OrderProductRepository $orderProductRepo, \Models\Services\ProductRepository $productRepo, \Models\Services\CurrencyRepository $currencyRepo )
    {
        $this->transactionRepo = $transactionRepo;
        $this->orderRepo = $orderRepo;
        $this->orderProductRepo = $orderProductRepo;
        $this->productRepo = $productRepo;
        $this->currencyRepo = $currencyRepo;
    }

    public function buildTransaction( $customer_id )
    {
        if ( $this->buildOrder( $customer_id ) )  {
            return true;
        }

        return false;
    }

    public function buildOrder( $customer_id )
    {
        // Get order
        $order = $this->orderRepo->getUnpaidOrderByCustomerID( $customer_id );
        if ( !is_null( $order->id ) ) {
            $this->setOrder( $order );

            // Get orderProducts
            $orderProducts = $this->orderProductRepo->getAllByOrderID( $order->id );

            // Populate orderProducts with respective Product object
            $this->populateOrderProducts( $orderProducts );

            $this->setOrderProducts( $orderProducts );

            return true;
        }

        return false;
    }

    private function setOrder( \Models\Order $order )
    {
        $this->order = $order;
    }

    public function getOrder()
    {
        if ( isset( $this->order ) ) {
            return $this->order;
        }
    }

    private function setOrderProducts( array $orderProducts )
    {
        foreach ( $orderProducts as $orderProduct ) {
            if ( !is_a( $orderProduct, "\Models\OrderProduct" ) ) {
                return false;
            }
        }

        $this->orderProducts = $orderProducts;
    }

    public function getOrderProducts()
    {
        if ( isset( $this->orderProducts ) ) {
            return $this->orderProducts;
        }
    }

    private function populateOrderProducts( array $orderProducts )
    {
        // Assign product data to orderProduct
        foreach ( $orderProducts as $_orderProduct ) {
            // Get the product associated with this order product
            $product = $this->productRepo->getByID( $_orderProduct->product_id );
            // Get the currency for this order product and add the currency
            // symbol as a dynamically added property of the product object
            $currency = $this->currencyRepo->getByCode( $product->currency );
            $product->currency_symbol = $currency->symbol;
            // Dynamically assign product as 'product' property of orderProduct
            $_orderProduct->product = $product;

            // All Products with a product type of 1 are subscriptions.
            if ( $_orderProduct->product->product_type_id == 1 ) {
                $this->addSubscriptionOrderProduct( $_orderProduct );
            }

            $this->addToTransactionTotal( ( $_orderProduct->product->price * $_orderProduct->quantity ) );
        }

    }

    private function addSubscriptionOrderProduct( \Models\OrderProduct $orderProduct )
    {
        // Update hasSubscription flag
        if ( !$this->hasSubscription ) {
            $this->hasSubscription = true;
        }

        $this->subscriptionOrderProducts[] = $orderProduct;
    }

    public function getTransactionTotal()
    {
        return $this->transaction_total;
    }

    public function hasSubscription()
    {
        return $this->hasSubscription;
    }

    public function markOrderAsPaid()
    {
        $this->orderRepo->updatePaidByID( $this->order->id, 1 );
    }

    public function setPaymentRedirectURL( $url )
    {
        $this->payment_redirect_url = $url;
    }

    public function getPaymentRedirectURL()
    {
        return $this->payment_redirect_url;
    }

    public function saveTransaction( $customer_id, $status, $transaction_type )
    {
        $order = $this->getOrder();
        // Create a transaction object
        $transaction = $this->transactionRepo->create( $customer_id, $order->id, $status, $transaction_type, $this->getTransactionTotal() );

        return $transaction;
    }

    private function addToTransactionTotal( $amount )
    {
        $this->transaction_total = $this->transaction_total + $amount;
    }

    public function getSubscriptionOrderProducts()
    {
        return $this->subscriptionOrderProducts;
    }
}
