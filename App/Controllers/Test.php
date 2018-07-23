<?php

namespace Controllers;

use \Core\Controller;

class Test extends Controller
{
    public function indexAction()
    {
        $Config = $this->load( "config" );
        $input = $this->load( "input" );

        $configs = $Config::$configs[ "braintree" ];

        $gateway = new \Braintree_Gateway([
            'environment' => $configs[ "environment" ],
            'merchantId' => $configs[ "credentials" ][ "merchant_id" ],
            'publicKey' => $configs[ "credentials" ][ "public_key" ],
            'privateKey' => $configs[ "credentials" ][ "private_key" ]
        ]);

        $clientToken = $gateway->clientToken()->generate();

        $this->view->assign( "client_token", $clientToken );

        $this->view->setTemplate( "braintree-test.tpl" );
        $this->view->render( "App/Views/Home.php" );
    }

    public function sequenceMangerAction()
    {
        $sequenceManager = $this->load( "sequence-manager" );
        $sequenceManager->dispatch();
    }
}
