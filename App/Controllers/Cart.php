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

        // Set default currency symbol to USD
        $currency_symbol = "$";

        // Assign product data to orderProduct
        foreach ( $orderProducts as $_orderProduct ) {
            $product = $productRepo->getByID( $_orderProduct->product_id );
            $currency = $currencyRepo->getByCode( $product->currency );
            $product->currency_symbol = $currency->symbol;
            $_orderProduct->product = $product;
            $transaction_total = $transaction_total + ( $_orderProduct->product->price * $_orderProduct->quantity );
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

        $this->view->setTemplate( "cart/pay.tpl" );
        $this->view->render( "App/Views/AccountManager.php" );
    }

    /*
        This method will be called asynchronously to process payments.
        NOTE "before" and "after" methods will not be called when a method with
        the suffix "Action" is invoked via ajax request
    */
    public function processPayment()
    {
        // Loading services
        $userAuth = $this->load( "user-authenticator" );
        $accountRepo = $this->load( "account-repository" );
        $accountUserRepo = $this->load( "account-user-repository" );
        $currencyRepo = $this->load( "currency-repository" );
        $userRepo = $this->load( "user-repository" );
        $input = $this->load( "input" );
        $inputValidator = $this->load( "input-validator" );
        $orderRepo = $this->load( "order-repository" );
        $orderProductRepo = $this->load( "order-product-repository" );
        $productRepo = $this->load( "product-repository" );
        $customerRepo = $this->load( "customer-repository" );
        $braintreeGatewayInit = $this->load( "braintree-gateway-initializer" );
        $groupRepo = $this->load( "group-repository" );
        $logger = $this->load( "logger" );

        // If user not validated with session or cookie, send them to sign in
        if ( !$userAuth->userValidate() ) {
            $this->view->redirect( "account-manager/sign-in" );
        }

        // User is logged in. Get the user object from the UserAuthenticator service
        $user = $userAuth->getUser();

        // Get AccountUser reference
        $accountUser = $accountUserRepo->getByUserID( $user->id );

        // Grab account details
        $account = $accountRepo->getByID( $accountUser->account_id );

        if ( $input->exists() && $inputValidator->validate(

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
            $customer = $customerRepo->getByAccountID( $account->id );

            // Get the current order of this customer
            $order = $orderRepo->getUnpaidOrderByCustomerID( $customer->id );

            // Get orderProducts
            $orderProducts = $orderProductRepo->getAllByOrderID( $order->id );

            // Transaction Total
            $transaction_total = 0;

            // Default currency symbol
            $currency_symbol = "$";

            // Assign product data to orderProduct
            foreach ( $orderProducts as $_orderProduct ) {
                $product = $productRepo->getByID( $_orderProduct->product_id );
                $currency = $currencyRepo->getByCode( $product->currency );
                $product->currency_symbol = $currency->symbol;
                $_orderProduct->product = $product;
                $transaction_total = $transaction_total + ( $_orderProduct->product->price * $_orderProduct->quantity );
            }

            // Use api credentials stored in configs to create a gateway object
            // to establish communication with the braintree API.
            $gateway = $braintreeGatewayInit->init();

            $result = $gateway->transaction()->sale( [
                'amount' => $transaction_total,
                'paymentMethodNonce' => $input->get( "payment_method_nonce" ),
                'options' => [
                    'submitForSettlement' => True
                ]
            ] );

            if ( $result->success ) {
                $groupRepo->create( 45, "Transaction", json_encode( $result ) );
                $orderRepo->updatePaidByID( $order->id, 1 );
            }
        }
    }

    public function paymentSuccess()
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
