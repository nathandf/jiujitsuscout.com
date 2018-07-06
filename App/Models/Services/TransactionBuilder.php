<?php

namespace Models\Services;

use Models\Composites\Item;
use Models\Composites\ItemList;
use Models\Composites\TransactionDetails;
use Models\Composites\Amount;
use Models\Composites\Transaction;

class TransactionBuilder
{

  public $productRepo;
  public $itemList;
  public $transactionDetails;
  public $amount;
  public $transaction;

  public function __construct( \Models\Services\ProductRepository $productRepo )
  {
    $this->productRepo = $productRepo;
  }

  public function buildItems( array $product_data )
  {
    $items = [];
    $item_id = 1;

    foreach ( $product_data as $data ) {
      $product = $this->productRepo->getByID( $data[ "product_id" ] );
      $quantity = $data[ "quantity" ];
      // Create Item from Product
      $item = new Item( $product, $quantity );
      $item->setID( $item_id );
      $items[] = $item;
      $item_id++;
    }

    return $items;
  }

  public function buildItemList( array $items )
  {
    $itemList = new ItemList( $items );
    $this->setItemList( $itemList );

    return $itemList;
  }

  public function setItemList( $itemList )
  {
    $this->itemList = $itemList;
  }

  public function buildTransactionDetails( $itemList, $discount )
  {
    $sub_total = 0;
    $transactionDetails = new TransactionDetails;
    foreach ( $itemList->getItems() as $item ) {
      $sub_total = ( $sub_total + $item->price ) * $item->quantity;
    }
    $transactionDetails->setSubTotal( $sub_total );
    $transactionDetails->setDiscount( $discount );

    $this->setTransactionDetails( $transactionDetails );

    return $transactionDetails;
  }

  private function setTransactionDetails( $transactionDetails )
  {
    $this->transactionDetails = $transactionDetails;
  }

  public function buildAmount( $transactionDetails, $currency )
  {
    $amount = new Amount( $transactionDetails );
    $amount->setCurrency( $currency );

    $this->setAmount( $amount );

    return $amount;
  }

  private function setAmount( $amount )
  {
    $this->amount = $amount;
  }

  public function buildTransaction( array $product_data, $currency, $discount )
  {
    $items = $this->buildItems( $product_data );
    $itemList = $this->buildItemList( $items );
    $this->validateItemCurrencies( $itemList, $currency );
    $transactionDetails = $this->buildTransactionDetails( $itemList, $discount );
    $amount = $this->buildAmount( $transactionDetails, $currency );

    $transaction = new Transaction( $itemList, $transactionDetails, $amount );

    return $transaction;
  }

  private function validateItemCurrencies( $itemList, $currency )
  {
    // Verify that the currencies of the items match that of the transaction as a whole
    foreach ( $itemList->getItems() as $item ) {
      if ( $item->currency != $currency ) {
        throw new \Exception( "One or more of the item's currencies did not match the transaction currency" );
      }
    }
  }

}
