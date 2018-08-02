<?php

namespace Controllers;

use \Core\Controller;

class Test extends Controller
{
    public function braintree()
	{
        $input = $this->load( "input" );
        $inputValidator = $this->load( "input-validator" );
		$productRepo = $this->load( "product-repository" );

        $products = $productRepo->getAll();

        $this->view->assign( "products", $products );

		$this->view->assign( "csrf_token", $this->session->generateCSRFToken() );
	    $this->view->setErrorMessages( $inputValidator->getErrors() );

		$this->view->setTemplate( "braintree-test.tpl" );
		$this->view->render( "App/Views/Home.php" );
	}

    public function sequenceManagerAction()
    {
        $sequenceManager = $this->load( "sequence-dispatcher" );
        $sequenceManager->dispatch();
    }

    public function transactions()
    {
        $transactionRepo = $this->load( "transaction-repository" );
        $braintreeTransactionRepo = $this->load( "braintree-transaction-repository" );

        $transactionRepo->create( 0,0,0,0,0 );
        $braintreeTransactionRepo->create([
            "transaction_id" => 0,
            "transaction_status" => 0,
            "transaction_type" => 0,
            "transaction_currency_iso_code" => 0,
            "transaction_amount" => 0,
            "message" => 0,
            "merchant_account_id" => 0,
            "sub_merchant_account_id" => 0,
            "master_merchant_account_id" => 0,
            "order_id" => 0,
            "processor_response_code" => 0,
            "full_transaction_data" => json_encode( 0 )
        ]);

    }
}
