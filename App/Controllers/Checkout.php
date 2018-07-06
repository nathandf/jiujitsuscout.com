<?php

namespace Controllers;

use Core\Controller;

class Checkout extends Controller
{

  public function before()
  {
    
  }

  public function indexAction()
  {
    echo "Index Action";
  }

  public function cartAction()
  {
    $form = $this->load( "form" );
    $formValidator = $this->load( "form-validator" );
    $transactionBuilder = $this->load( "transaction-builder" );
    if ( $form->isSubmitted( "get" ) && $formValidator->validate( $form, [ "product_data", "currency" ] ) ) {
      $discount = 0;
      if ( $form->issetField( "discount" ) ) {
        $discount = $form->get( "discount" );
      }

      foreach ( $form->get( "product_data" ) as $key => $data) {
        if ( !isset( $_GET[ "product_data" ][ $key ][ "product_id" ] ) || $_GET[ "product_data" ][ $key ][ "quantity" ] < 1 ) {
          unset( $_GET[ "product_data" ][ $key ] );
        }
      }

      $transaction = $transactionBuilder->buildTransaction( $form->get( "product_data" ), $form->get( "currency" ), $discount );
      // $paymentManager = $this->load( "paypal-payment-manager" );
      // $paymentManager->setTransaction( $transaction );
      // $paymentManager->setUpPayment();
      //
      // $this ->view->redirect( $paymentManager->getRedirectURL(), null, $external_redirect = true );

      $this->view->assign( "items", $transactionBuilder->itemList->getItems() );
      $this->view->assign( "sub_total", $transactionBuilder->transactionDetails->sub_total );
      $this->view->assign( "discount", $transactionBuilder->transactionDetails->discount );
      $this->view->assign( "total", $transactionBuilder->amount->total );

    } else {
      $this->view->assign( "items", null );
    }

    $this->view->setTemplate( "checkout/cart.tpl" );
    $this->view->render( "App/Views/checkout.php" );

  }

  public function payAction()
  {
    echo "Pay";
  }

  public function processPaymentAction()
  {
    $form = $this->load( "form" );
    $formValidator = $this->load( "form-validator" );
    $paymentManager = $this->load( "payment-manager" );

    if ( $form->isSubmitted( "get" ) && $formValidator->validate( $form, [ "status" ] ) ) {
      if ( $form->get( "status" ) == "success" && $formValidator->validate( $form, [ "paymentId", "token", "PayerID" ] ) ) {
        $paymentManager->setPaymentId( $form->get( "paymentId" ) );
        $paymentManager->setToken( $form->get( "token" ) );
        $paymentManager->setPayerID( $form->get( "PayerID" ) );
        $paymentManager->executePayment();
      } elseif ( $form->get( "status" ) == "cancelled" ) {
        echo( "Payment Cancelled" );
      }
    }
  }

  public function productsAction()
  {
    $productRepo = $this->load( "product-repository" );
    $products = $productRepo->getAll();

    $this->view->assign( "products", $products );

    $this->view->setTemplate( "checkout/products.tpl" );
    $this->view->render( "App/Views/checkout.php" );
  }

  public function errorAction()
  {
    echo "There was an Error";
  }

}
