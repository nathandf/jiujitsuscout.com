<?php

namespace Model\Services;

use PayPal\Api\Payer as PP_Payer;
use PayPal\Api\Item as PP_Item;
use PayPal\Api\ItemList as PP_ItemList;
use PayPal\Api\Details as PP_Details;
use PayPal\Api\Amount as PP_Amount;
use PayPal\Api\Transaction as PP_Transaction;
use PayPal\Api\RedirectUrls as PP_RedirectUrls;
use PayPal\Api\Payment as PP_Payment;
use PayPal\Api\PaymentExecution  as PP_PaymentExecution;

class PayPalPaymentManager
{

  public $transaction;
  public $apiContext;
  public $redirect_url;
  public $error_redirect_url = "account-manager/checkout/error";

  public function __construct( \Model\Services\PayPalApiInitializer $paypal_api_initializer )
  {
    $this->setApiContext( $paypal_api_initializer->init() );
  }

  public function setTransaction( \Model\Transaction $transaction )
  {
    $this->transaction = $transaction;
  }

  public function setUpPayment()
  {
    // PayPal Payer
    $pp_payer = new PP_Payer;
    $pp_payer->setPaymentMethod( "paypal" );

    $pp_items = [];

    // Populate PayPal Items from Transaction->itmes_list;
    foreach ( $this->transaction->item_list as $item ) {
      // PayPal Item
      $pp_item = new PP_Item();
      // Populate PayPal Item details
      $pp_item->setName( $item->name )
              ->setCurrency( $item->currency )
              ->setQuantity( $item->quantity )
              ->setPrice( $item->price );
      $pp_items[] = $pp_item;
    }

    $pp_itemList = new PP_ItemList();
    $pp_itemList->setItems( $pp_items );

    $pp_details = new PP_Details();
    $pp_details->setSubtotal( $transaction->details->sub_total );

    $pp_amount = new PP_Amount();
    $pp_amount->setCurrency( $transaction->amount->currency )
              ->setTotal( $transaction->amount->total )
              ->setDetails( $pp_details );

    $pp_transaction = new PP_Transaction();
    $pp_transaction->setAmount( $pp_amount )
                ->setItemList( $pp_itemList )
                ->setDescription( "PayPal Payment Test" )
                ->setInvoiceNumber( uniqid() );

    $pp_redirectUrls = new PP_RedirectUrls();
    $pp_redirectUrls->setReturnURL( "http://localhost/projects/dev.jiujitsuscout.com/checkout/process-payment?status=success" )
                 ->setCancelURL( "http://localhost/projects/dev.jiujitsuscout.com/checkout/process-payment?status=cancelled" );

    $pp_payment = new PP_Payment();
    $pp_payment->setIntent( "sale" )
            ->setPayer( $pp_payer )
            ->setRedirectUrls( $pp_redirectUrls )
            ->setTransactions( [ $pp_transaction ] );

    try {
      $pp_payment->create( $this->getApiContext() );
    } catch ( \Exception $e ) {
      die( $e );
    }

    $this->setRedirectURL( $pp_payment->getApprovalLink() );
  }

  public function executePayment()
  {
    $pp_payment = PP_Payment::get( $this->getPaymentId(), $this->getApiContext() );
    $pp_paymentExecution = new PP_PaymentExecution();
    $pp_paymentExecution->setPayerId( $this->getPayerID() );

    try {
      $result = $pp_payment->execute( $pp_paymentExecution, $this->getApiContext() );
    } catch (\Exception $e) {
      die( "An error occured" );
    }

    echo "Payment Successful";

  }

  private function setRedirectURL( $url )
  {
    $this->redirect_url = $url;
  }

  public function getRedirectURL()
  {
    if ( isset( $this->redirect_url ) ) {
      return $this->redirect_url;
    }

    return $this->error_redirect_url;
  }

  private function setApiContext( $apiContext )
  {
    $this->apiContext = $apiContext;
  }

  public function getApiContext()
  {
    return $this->apiContext;
  }

  public function setPaymentId( $paymentId )
  {
    $this->paymentId = $paymentId;
  }

  public function getPaymentId()
  {
    return $this->paymentId;
  }

  public function setToken( $token )
  {
    $this->token = $token;
  }

  public function getToken()
  {
    return $this->token;
  }

  public function setPayerID( $PayerID )
  {
    $this->PayerID = $PayerID;
  }

  public function getPayerID()
  {
    return $this->PayerID;
  }

}
