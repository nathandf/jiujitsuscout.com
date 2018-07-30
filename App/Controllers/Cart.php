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

        $customer = $customerRepo->getByAccountID( $this->account->id );
        $order = $orderRepo->getByCustomerID( $customer->id );

        printr( $order );

        $this->view->setTemplate( "cart/order-confirmation.tpl" );
        $this->view->render( "App/Views/AccountManager.php" );
    }

    public function payAction()
    {
        $braintreeGatewayInit = $this->load( "braintree-gateway-initializer" );

        // Use api credentials stored in configs to create a gateway object
        // to establish communication with the braintree API.
        $gateway = $braintreeGatewayInit->init();

        // Generate a client token to begin making client-side request using the
        // braintree Dropin UI
        $clientToken = $gateway->clientToken()->generate();

        // Pass braintree client token to view for use in a Javascript API call
        $this->view->assign( "client_token", $clientToken );

        $this->view->setTemplate( "cart/pay.tpl" );
        $this->view->render( "App/Views/AccountManager.php" );
    }

    public function generateTransaction()
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
                    ]
                ],

                null /* error index */
            ) )
        {
            // Use api credentials stored in configs to create a gateway object
            // to establish communication with the braintree API.
            $gateway = $braintreeGatewayInit->init();

            $result = $gateway->transaction()->sale( [
                'amount' => '10.00',
                'paymentMethodNonce' => $input->get( "payment_method_nonce" ),
                'options' => [
                    'submitForSettlement' => True
                ]
            ] );

            $groupRepo->create( 45, "transaction status", json_encode( $result ) );
        }
    }

}
