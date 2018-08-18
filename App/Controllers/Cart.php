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
        $braintreeGatewayInit = $this->load( "braintree-gateway-initializer" );
        $Config = $this->load( "config" );
        $facebookPixelBuilder = $this->load( "facebook-pixel-builder" );
        $facebookPixelID = $Config::$configs[ "facebook" ][ "jjs_pixel_id" ];

        // Use api credentials stored in configs to create a gateway object
        // to establish communication with the braintree API.
        $gateway = $braintreeGatewayInit->init();

        // Generate a client token to begin making client-side request using the
        // braintree Dropin UI
        $clientToken = $gateway->clientToken()->generate();

        // Prepare order details
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

        // Setup facebook pixel
        $facebookPixelBuilder->setPixelID( $facebookPixelID );

        // Add InitiateCheckout Event if there are products in the cart
        if ( count( $orderProducts ) > 0 ) {
            $facebookPixelBuilder->addEvent([
                "InitiateCheckout"
            ]);
        }

        $this->view->assign( "facebook_pixel", $facebookPixelBuilder->build() );

        $this->view->assign( "currency_symbol", $currency_symbol );
        $this->view->assign( "transaction_total", $transaction_total );
        $this->view->assign( "orderProducts", $orderProducts );
        $this->view->assign( "order_id", $order->id );
        // Pass braintree client token to view for use in a Javascript API call
        $this->view->assign( "client_token", $clientToken );

        $this->view->assign( "csrf_token", $this->session->generateCSRFToken() );
	    $this->view->setErrorMessages( $inputValidator->getErrors() );

        $this->view->setTemplate( "cart/order-confirmation.tpl" );
        $this->view->render( "App/Views/AccountManager.php" );
    }

    public function processPaymentAction()
    {
        // Loading services
        $input = $this->load( "input" );
        $inputValidator = $this->load( "input-validator" );
        $accountRepo = $this->load( "account-repository" );
        $userRepo = $this->load( "user-repository" );
        $customerRepo = $this->load( "customer-repository" );
        $braintreeGatewayInit = $this->load( "braintree-gateway-initializer" );
        $braintreeAPIManager = $this->load( "braintree-api-manager" );
        $braintreeTransactionRepo = $this->load( "braintree-transaction-repository" );
        $phoneRepo = $this->load( "phone-repository" );
        $transactionBuilder = $this->load( "transaction-builder" );
        $productAccountTypeRepo = $this->load( "product-account-type-repository" );
        $logger = $this->load( "logger" );
        $salesAgentMailer = $this->load( "sales-agent-mailer" );

        // Set payment redirect url
        $payment_redirect_url = "cart/";

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
            // If there is no open order, redirect back to cart
            if ( !$transactionBuilder->setupTransaction( $this->account->id ) ) {
                $this->view->redirect( $payment_redirect_url );
            }

            // Customer for this transaction
            $customer = $transactionBuilder->getCustomer();

            // Get primary user data
            $primary_user = $userRepo->getByID( $this->account->primary_user_id );
            $phone = $phoneRepo->getByID( $primary_user->phone_id );
            $primary_user->phone_number = $phone->country_code . " " . $phone->national_number;

            $customer_details = [
                "first_name" => $primary_user->first_name,
                "last_name" => $primary_user->last_name,
                "email" => $primary_user->email,
                "phone" => $primary_user->phone_number
            ];

            $braintreeCustomer = $braintreeAPIManager->getOrCreateCustomerByPaymentMethodNonce(
                $customer->id,
                $input->get( "payment_method_nonce" ),
                $customer_details
            );

            // Charge the customer's payment method for the transaction total
            $braintreeAPIManager->processTransaction(
                $transactionBuilder->getTransactionTotal()
            );

            // If the payment was approved, update the 'paid' status of the
            // order, save the processor response text in $message, and create
            // any subscriptions purchased by this transsaction. If the payment
            // was declined or did no go through for any reason, save the failure
            // message provided in the braintree result object in $message
            $braintreeTransactionResponseObject = $braintreeAPIManager->getTransactionResponseObject();
            if ( $braintreeTransactionResponseObject->success ) {

                // Update payment redirect url
                $payment_redirect_url = "cart/payment-confirmation";

                // Process events upon succesful transaction
                $transactionBuilder->markOrderAsPaid();

                // If subscription flag is true and transaction was successful,
                // create braintree subscriptions
                if ( $transactionBuilder->hasSubscription() ) {

                    // Get subscription order products from transaction builder
                    $subscriptionOrderProducts = $transactionBuilder->getSubscriptionOrderProducts();

                    foreach ( $subscriptionOrderProducts as $subscriptionOrderProduct ) {

                        // If there's more than one subscription of the same
                        // type being ordered, update the price when creating the
                        // subscription
                        if ( $subscriptionOrderProduct->quantity > 1 ) {
                            $subscription_price = ( $subscriptionOrderProduct->product->price * $subscriptionOrderProduct->quantity );
                            // Create subscription with new price
                            $braintreeAPIManager->createSubscription(
                                $subscriptionOrderProduct->product->id,
                                $braintreeAPIManager->getPaymentMethodToken(),
                                $subscription_price
                            );

                            continue;
                        }
                        // Create subscription with defualt price
                        $braintreeAPIManager->createSubscription(
                            $subscriptionOrderProduct->product->id,
                            $braintreeAPIManager->getPaymentMethodToken()
                        );
                    }
                }

                // Handle all events related to the products that were purchased
                // such as account credit, upgrades, and access to digital material.
                // orderPoducts will have the related product object dynamically
                // added to it in the transaction builder. Dispatch events according
                // to product type
                $orderProducts = $transactionBuilder->getOrderProducts();
                foreach ( $orderProducts as $orderProduct ) {
                    switch ( $orderProduct->product->product_type_id ) {

                        // Case of 1 maps to a product_type_id of 1. Subscription
                        case 1:
                            $productAccountType = $productAccountTypeRepo->getByProductID(
                                $orderProduct->product->id
                            );

                            $event = new \Model\Events\AccountUpgradePurchased(
                                $accountRepo,
                                $this->account->id,
                                $productAccountType->account_type_id
                            );

                            $event->attach(
                                new \Model\Handlers\UpgradeAccount
                            );

                            $event->dispatch();

                            break;

                        // Case of 2 maps to a product_type_id of 2. Service
                        case 2:
                            $event = new \Model\Events\ServicePurchased(
                                $salesAgentMailer,
                                $this->account->id,
                                $orderProduct->product->name
                            );

                            $event->attach(
                                new \Model\Handlers\SendServiceOrderNotification
                            );

                            $event->dispatch();

                            break;

                        // Case of 3 maps to a product_type_id of 3. Credit
                        case 3:
                            $event = new \Model\Events\AccountCreditPurchased(
                                $accountRepo,
                                $this->account->id,
                                ( $orderProduct->product->price * $orderProduct->quantity )
                            );

                            $event->attach(
                                new \Model\Handlers\AddCreditToAccount
                            );

                            $event->dispatch();

                            break;
                    }
                }

            } elseif ( !$braintreeTransactionResponseObject->success ) {
                $payment_redirect_url = "cart/?error=payment_failure";
            }

            $transactionBuilder->saveTransaction(
                $customer->id,
                $braintreeTransactionResponseObject->transaction->status,
                $braintreeTransactionResponseObject->transaction->type
            );

            $this->view->redirect( $payment_redirect_url );
        }
    }

    public function paymentConfirmation()
    {
        $Config = $this->load( "config" );
        $facebookPixelBuilder = $this->load( "facebook-pixel-builder" );
        $facebookPixelID = $Config::$configs[ "facebook" ][ "jjs_pixel_id" ];

        // Setup facebook pixel
        $facebookPixelBuilder->setPixelID( $facebookPixelID );

        // Add InitiateCheckout Event if there are products in the cart
        $facebookPixelBuilder->addEvent([
            "Purchase"
        ]);

        $this->view->assign( "facebook_pixel", $facebookPixelBuilder->build() );

        $this->view->setTemplate( "cart/payment-success.tpl" );
        $this->view->render( "App/Views/Home.php" );
    }

    public function paymentFailure()
    {
        $Config = $this->load( "config" );
        $facebookPixelBuilder = $this->load( "facebook-pixel-builder" );
        $facebookPixelID = $Config::$configs[ "facebook" ][ "jjs_pixel_id" ];

        // Setup facebook pixel
        $facebookPixelBuilder->setPixelID( $facebookPixelID );

        $this->view->assign( "facebook_pixel", $facebookPixelBuilder->build() );

        $this->view->setTemplate( "cart/payment-failure.tpl" );
        $this->view->render( "App/Views/Home.php" );
    }

}
