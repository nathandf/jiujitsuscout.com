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
        $customerRepo = $this->load( "customer-repository" );
        $orderRepo = $this->load( "order-repository" );
        $orderProductRepo = $this->load( "order-product-repository" );
        $productRepo = $this->load( "product-repository" );
        $currencyRepo = $this->load( "currency-repository" );

        $transaction_total = 0;

        $customer = $customerRepo->getByAccountID( $this->account->id );
        $order = $orderRepo->getByCustomerID( $customer->id );

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
            $currency_symbol = $currency->symbol;
        }

        $this->view->assign( "currency_symbol", $currency_symbol );
        $this->view->assign( "transaction_total", $transaction_total );
        $this->view->assign( "orderProducts", $orderProducts );

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
                    "total" => [
                        "required" => true,
                    ]
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

        $this->view->setTemplate( "cart/pay.tpl" );
        $this->view->render( "App/Views/AccountManager.php" );
    }

    public function processPayment()
    {
        $input = $this->load( "input" );
        $inputValidator = $this->load( "input-validator" );
        $groupRepo = $this->load( "group-repository" );
        $braintreeGatewayInit = $this->load( "braintree-gateway-initializer" );

        if ( $input->exists() && $inputValidator->validate(

                $input,

                [
                    "payment_method_nonce" => [
                        "required" => true
                    ],
                    "total" => [
                        "required" => true
                    ]
                ],

                null /* error index */
            ) )
        {
            // Use api credentials stored in configs to create a gateway object
            // to establish communication with the braintree API.
            $gateway = $braintreeGatewayInit->init();

            $result = $gateway->transaction()->sale( [
                'amount' => $input->get( "total" ),
                'paymentMethodNonce' => $input->get( "payment_method_nonce" ),
                'options' => [
                    'submitForSettlement' => True
                ]
            ] );

            $groupRepo->create( 45, "transaction status", json_encode( $result ) );
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
