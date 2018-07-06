<?php

namespace Helpers;

class Form
{
  private $method;
  public $data;

  public function isSubmitted( $method = "post" )
  {
    if ( $method == "post" ) {
      if ( empty( $_POST ) ) {
        return false;
      } else {
        $this->setMethod( $method );
        $this->setData( $_POST );
        return true;
      }
    } elseif( $method == "get"  ) {
      if ( empty( $_GET ) ) {
        return false;
      } else {
        $this->setMethod( $method );
        $this->setData( $_GET );
        return true;
      }
    }
    return false;
  }

  public function get( $item, $filter_var_flag = FILTER_SANITIZE_FULL_SPECIAL_CHARS )
  {
    $request = $_POST; // default
    if ( $this->method == "get" ) {
      $request = $_GET;
    }
    if ( isset( $request[ $item ] ) ) {
        if ( is_null( $filter_var_flag ) ) {
            return $request[ $item ];
        } else {
            return filter_var( $request[ $item ], $filter_var_flag );
        }
    } else {
      return "";
    }
  }

  public function update( $item, $value )
  {
    $request = $_POST; // default
    if ( $this->method == "get" ) {
      $request = $_GET;
    }
    if ( isset( $request[ $item ] ) ) {
      $request[ $item ] = $value;
      switch ( $this->method ) {
        case "get":
          $_GET[ $item ] = $value;
          echo "get";
          break;
        case "post":
          $_POST[ $item ] = $value;
          break;
      }
    }
  }

  public function addField( $field, $value )
  {

    if ( $this->method == "get" ) {
      $_GET[ $field ] = $value;
    } elseif ( $this->method == "post" ) {
      $_POST[ $field ] = $value;
    }

    $this->data[ $field ] = $value;


  }

  public function issetField( $field )
  {
    $data = $this->getData();
    if ( isset( $data[ $field ] ) && $data[ $field ] != "" ) {
      return true;
    }

    return false;
  }

  public function setData( $data )
  {
    $this->data = $data;
  }

  private function getData()
  {
    return $this->data;
  }

  public function setMethod( $method )
  {
    $this->method = $method;
  }

}
