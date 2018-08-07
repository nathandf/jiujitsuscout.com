<?php

namespace Controllers;

use Core\Controller;

class Cart extends Controller
{
    private $businesses = [];
    private $business;
    private $account;
    private $user;

    public function before()
    {
        // Loading services
        $userAuth = $this->load( "user-authenticator" );
        $accountRepo = $this->load( "account-repository" );
        $accountUserRepo = $this->load( "account-user-repository" );
        $accountTypeRepo = $this->load( "account-type-repository" );
        $businessRepo = $this->load( "business-repository" );
        $userRepo = $this->load( "user-repository" );
        $logger = $this->load( "logger" );
        // If user not validated with session or cookie, send them to sign in
        if ( !$userAuth->userValidate() ) {
            $this->view->redirect( "account-manager/sign-in" );
        }
        // User is logged in. Get the user object from the UserAuthenticator service
        $this->user = $userAuth->getUser();
        // Get AccountUser reference
        $accountUser = $accountUserRepo->getByUserID( $this->user->id );
        // Grab account details
        $this->account = $accountRepo->getByID( $accountUser->account_id );
        // Get account type details
        $this->account_type = $accountTypeRepo->getByID( $this->account->account_type_id );
        // Grab business details
        $this->business = $businessRepo->getByID( $this->user->getCurrentBusinessID() );

        // Set data for the view
        $this->view->assign( "account_type", $this->account_type );
        $this->view->assign( "account", $this->account );
        $this->view->assign( "user", $this->user );
        $this->view->assign( "business", $this->business );
    }

    public function indexAction()
    {
        $input = $this->load( "input" );
        $inputValidator = $this->load( "input-validator" );
        $customerRepo = $this->load( "customer-repository" );
        $orderRepo = $this->load( "order-repository" );
        $orderProductRepo = $this->load( "order-product-repository" );
        $productRepo = $this->load( "product-repository" );
        $currencyRepo = $this->load( "currency-repository" );

        $transaction_total = 0;

        $customer = $customerRepo->getByAccountID( $this->account->id );
        $order = $orderRepo->getUnpaidOrderByCustomerID( $customer->id );

        $orderProducts = $orderProductRepo->getAllByOrderID( $order->id );
        $order_product_ids = [];

        // Set default currency symbol to USD
        $currency_symbol = "$";

        // Assign product data to orderProduct
        foreach ( $orderProducts as $_orderProduct ) {
            $product = $productRepo->getByID( $_orderProduct->product_id );
            $currency = $currencyRepo->getByCode( $product->currency );
            $product->currency_symbol = $currency->symbol;
            $_orderProduct->product = $product;
            $order_product_ids[] = $_orderProduct->id;
            $transaction_total = $transaction_total + ( $_orderProduct->product->price * $_orderProduct->quantity );
        }

        if ( $input->exists() && $input->issetField( "delete" ) && $inputValidator->validate(

                $input,

                [
                    "token" => [
                        "equals-hidden" => $this->session->getSession( "csrf-token" ),
                        "required" => true
                    ],
                    "order_id" => [
                        "required" => true,
                        "equals" => $order->id
                    ],
                    "order_product_id" => [
                        "required" => true,
                        "in_array" => $order_product_ids
                    ]
                ],

                "delete" /* error index */
            ) )
        {
            if ( count( $orderProducts ) < 1 ) {
                // If there is only one product in the cart, delete product from
                // the order, then delete the order itself
                $orderProductRepo->deleteByID( $input->get( "order_product_id" ) );
                $orderRepo->removeByID( $order->id );
            } else {
                // If there's more than one item in the cart, simply delete that
                // item
                $orderProductRepo->removeByID( $input->get( "order_product_id" ) );
            }

            // Go back to the cart
            $this->view->redirect( "cart/" );
        }

        $this->view->assign( "currency_symbol", $currency_symbol );
        $this->view->assign( "transaction_total", $transaction_total );
        $this->view->assign( "orderProducts", $orderProducts );
        $this->view->assign( "order_id", $order->id );

        $this->view->assign( "csrf_token", $this->session->generateCSRFToken() );
	    $this->view->setErrorMessages( $inputValidator->getErrors() );

        $this->view->setTemplate( "cart/order-confirmation.tpl" );
        $this->view->render( "App/Views/AccountManager.php" );
    }

    public function payAction()
    {
        $input = $this->load( "input" );
        $inputValidator = $this->load( "input-validator" );
        $braintreeGatewayInit = $this->load( "braintree-gateway-initializer" );

        if ( $input->exists() && $inputValidator->validate(

                $input,

                [
                    "token" => [
                        "equals-hidden" => $this->session->getSession( "csrf-token" ),
                        "required" => true
                    ],
                ],

                "pay" /* error index */
            ) )
        {

        } else {
            $this->view->redirect( "cart/" );
        }

        // Use api credentials stored in configs to create a gateway object
        // to establish communication with the braintree API.
        $gateway = $braintreeGatewayInit->init();

        // Generate a client token to begin making client-side request using the
        // braintree Dropin UI
        $clientToken = $gateway->clientToken()->generate();

        // Pass braintree client token to view for use in a Javascript API call
        $this->view->assign( "client_token", $clientToken );
        $this->view->assign( "total", $input->get( "total" ) );
        $this->view->assign( "order_id", $input->get( "order_id" ) );

        $this->view->assign( "csrf_token", $this->session->generateCSRFToken() );
	    $this->view->setErrorMessages( $inputValidator->getErrors() );

        $this->view->setTemplate( "cart/pay-redirect.tpl" );
        $this->view->render( "App/Views/AccountManager.php" );
    }

    /*
        This method will be called asynchronously to process payments.
        NOTE "before" and "after" methods will not be called when a method with
        the suffix "Action" is invoked via ajax request
    */
    public function processPaymentAction()
    {
        // Loading services
        $input = $this->load( "input" );
        $inputValidator = $this->load( "input-validator" );
        $userRepo = $this->load( "user-repository" );
        $currencyRepo = $this->load( "currency-repository" );
        $orderRepo = $this->load( "order-repository" );
        $orderProductRepo = $this->load( "order-product-repository" );
        $productRepo = $this->load( "product-repository" );
        $customerRepo = $this->load( "customer-repository" );
        $braintreeGatewayInit = $this->load( "braintree-gateway-initializer" );
        $transactionRepo = $this->load( "transaction-repository" );
        $braintreeTransactionRepo = $this->load( "braintree-transaction-repository" );
        $phoneRepo = $this->load( "phone-repository" );
        $logger = $this->load( "logger" );

        if ( $input->exists( "get" ) && $inputValidator->validate(

                $input,

                [
                    "payment_method_nonce" => [
                        "required" => true
                    ],
                ],

                null /* error index */
            ) )
        {

            // Get customer associated with this account
            $customer = $customerRepo->getByAccountID( $this->account->id );

            // Get primary user data
            //TODO Change this from primary user to user role "owner"
            $primary_user = $userRepo->getByID( $this->account->primary_user_id );
            $phone = $phoneRepo->getByID( $primary_user->phone_id );
            $primary_user->phone_number = $phone->country_code . " " . $phone->national_number;

            // Get the current order of this customer
            $order = $orderRepo->getUnpaidOrderByCustomerID( $customer->id );
            // Redirect if no unpaid order exists
            if ( is_null( $order->id ) ) {
                $this->view->redirect( "cart/" );
            }

            // Get orderProducts
            $orderProducts = $orderProductRepo->getAllByOrderID( $order->id );

            // Transaction Total default
            $transaction_total = 0;

            // Flag for subscription
            $hasSubscription = false;

            // Flag for storing payment method in braintree vault on success
            $storeInVaultOnSuccess = false;

            // Subscription product number
            $subscriptionProductID = null;
            $subscriptionProductIDs = [];

            // Default post-payment redirect url
            $payment_redirect_url = "cart/";

            // Default currency symbol
            $currency_symbol = "$";

            // Assign product data to orderProduct
            foreach ( $orderProducts as $_orderProduct ) {
                $product = $productRepo->getByID( $_orderProduct->product_id );

                // All Products with a product type of 1 are subscriptions.
                if ( $product->product_type_id == 1 ) {
                    $hasSubscription = true;
                    $subscriptionProductID = $product->id;
                    $subscriptionProductIDs[] = $product->id;
                }
                $currency = $currencyRepo->getByCode( $product->currency );
                $product->currency_symbol = $currency->symbol;
                $_orderProduct->product = $product;
                $transaction_total = $transaction_total + ( $_orderProduct->product->price * $_orderProduct->quantity );
            }

            // Use api credentials stored in configs to create a gateway object
            // to establish communication with the braintree API.
            $gateway = $braintreeGatewayInit->init();

            // Check for a braintree customer using current customer id. If none
            // exists, create a new one with a new payment method using the
            // payment method nonce
            $braintreeCustomer = false;

            try {
                $braintreeCustomer = $gateway->customer()->find( $customer->id );
            } catch (\Exception $e) {
                $logger->info( "Braintree customer with id of " . $customer->id . " does not exists. Creating a new customer." );
            }

            if ( !$braintreeCustomer ) {
                // Create a new braintree customer using the current customer id
                $braintreeCustomerCreationResult = $gateway->customer()->create([
                    "id" => $customer->id,
                    "firstName" => $primary_user->first_name,
                    "lastName" => $primary_user->last_name,
                    "email" => $primary_user->email,
                    "phone" => $primary_user->phone_number,
                    "paymentMethodNonce" => $input->get( "payment_method_nonce" ),
                ]);

                // Update flag to trigger the payment methods storage in
                // braintree vault
                $storeInVaultOnSuccess = true;

                if ( $braintreeCustomerCreationResult->success ) {
                    $braintreeCustomer = $braintreeCustomerCreationResult->customer;
                } else {
                    $logger->error( "Could not create new customer" );
                    throw new \Exception( "Could not create new customer" );
                }
            }

            // Get braintree payment methods of braintree customer
            $braintreeCustomerPaymentMethods = $braintreeCustomer->paymentMethods;

            // Get braintree customer payment method token
            $braintreePaymentMethodToken = $braintreeCustomerPaymentMethods[ 0 ]->token;

            // Process payment as normal using customer id
            $braintreeSaleResult = $gateway->transaction()->sale( [
                "amount" => $transaction_total,
                "customerId" => $braintreeCustomer->id,
                "options" => [
                    "submitForSettlement" => true,
                    'storeInVaultOnSuccess' => $storeInVaultOnSuccess
                ]
            ] );

            // braintree transaction object to be used later
            $braintreeTransactionResult = $braintreeSaleResult->transaction;

            // Log transaction data
            $logger->info( "Braintree Transaction: " . $braintreeTransactionResult->id . " | Response Code: " . $braintreeTransactionResult->processorResponseCode . " | Response Text: " . $braintreeTransactionResult->processorResponseText );

            // If the payment was approved, update the 'paid' status of the
            // order, save the processor response text in $message, and create
            // any subscriptions purchased by this trasnsaction. If the payment
            // was declined or did no go through for any reason, save the failure
            // message provided in the braintree result object in $message
            if ( $braintreeSaleResult->success ) {
                $payment_redirect_url = $payment_redirect_url . "payment-confirmation";
                $orderRepo->updatePaidByID( $order->id, 1 );
                $message = $braintreeSaleResult->transaction->processorResponseText;

                // If subscription flag is true and trasnaction was successful,
                // create braintree subscriptions
                if ( $hasSubscription ) {

                    // Create a datetime object representing the same date next month
                    // This object will be used to specify the first billing date
                    $num_of_days = cal_days_in_month( CAL_GREGORIAN, date( "m" ), date( "Y" ) );
                    $modifier = "now + " . $num_of_days . " days";
                    $next_month = new \DateTime( $modifier );
                    $next_month->setTime( 0, 0, 0 );

                    $subscriptionResult = $gateway->subscription()->create([
                        "paymentMethodToken" => $braintreePaymentMethodToken,
                        "planId" => $subscriptionProductID,
                        'firstBillingDate' => $next_month
                    ]);

                    // Log subscription and transaction data
                    $logger->info( "Braintree Subscription Created | " . "Subscription ID: " . $subscriptionResult->subscription->subscriptionId );
                }

            } elseif ( !$braintreeSaleResult->success ) {
                $payment_redirect_url = $payment_redirect_url . "?error=payment_failure";
                $message = $braintreeSaleResult->message;
            }

            $logger->info( "Message: " . $message );

            // Create a braintreeTransaction object and save the transaction
            // data provided by braintree to the database.
            $braintreeTransaction = $braintreeTransactionRepo->create([
                "transaction_id" => $braintreeTransactionResult->id,
                "transaction_status" => $braintreeTransactionResult->status,
                "transaction_type" => $braintreeTransactionResult->type,
                "transaction_currency_iso_code" => $braintreeTransactionResult->currencyIsoCode,
                "transaction_amount" => $braintreeTransactionResult->amount,
                "message" => $message,
                "merchant_account_id" => $braintreeTransactionResult->merchantAccountId,
                "sub_merchant_account_id" => $braintreeTransactionResult->subMerchantAccountId,
                "master_merchant_account_id" => $braintreeTransactionResult->masterMerchantAccountId,
                "order_id" => $braintreeTransactionResult->orderId,
                "processor_response_code" => $braintreeTransactionResult->processorResponseCode,
                "full_transaction_data" => json_encode( $braintreeTransactionResult ),
            ]);

            // Create a transaction object
            $transaction = $transactionRepo->create( $customer->id, $order->id, $braintreeTransaction->braintree_transaction_status, $braintreeTransaction->braintree_transaction_type, $transaction_total );

            $this->view->redirect( $payment_redirect_url );
        }
    }

    public function paymentConfirmation()
    {
        // TODO add facbook pixel
        $this->view->setTemplate( "cart/payment-success.tpl" );
        $this->view->render( "App/Views/Home.php" );
    }

    public function paymentFailure()
    {
        // TODO add facbook pixel
        $this->view->setTemplate( "cart/payment-failure.tpl" );
        $this->view->render( "App/Views/Home.php" );
    }

}
