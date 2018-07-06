<?php

namespace Models\Services;

use Core\Session;

class UserAuthenticator extends Service
{

    public $repo;

  public function __construct( UserRepository $repo )
  {
    $this->repo = $repo;
  }

  public function userValidate()
  {
    if ( $this->isUserValidated() ) {
      switch ( $this->determineValidationType() ) {
        case "session":
          $user = $this->repo->getByID( $_SESSION[ "jjs_user_id" ] );
          $this->setUser( $user );
          break;
        case "cookie":
          $this->repo->getByToken( $_COOKIE[ "jiujitsuscout" ][ "user_login_token" ] );
          $this->setUser( $user );
          break;
        case null:
          return false;
      }

      return true;
    }

    return false;
  }

  public function loggedIn()
  {
    if ( !isset( $_SESSION[ "jjs_user_id" ] ) && !isset( $_COOKIE[ "jiujitsuscout" ][ "user_login_token" ] ) ) {
      // No session or token; needs to log in
      return false;
    } elseif ( !isset( $_SESSION[ "jjs_user_id" ]  ) && isset( $_COOKIE[ "jiujitsuscout" ][ "user_login_token" ] ) ) {
      // Token but no session; get user_id from db by token and set session
      $user = $this->repo->getByToken( $_COOKIE[ "jiujitsuscout" ][ "user_login_token" ] );
      // User is logged in. Check if a busienss has been chosen
      return $user;
    } else {
      // Session isset. Get by id
      $user = $this->repo->getByID( $_SESSION[ "jjs_user_id" ] );
      return $user;
    }
  }

  private function determineValidationType()
  {
    if ( isset( $_SESSION[ "jjs_user_id" ]  )  ) {
      return "session";
    } elseif ( isset( $_COOKIE[ "jiujitsuscout" ][ "user_login_token" ] ) ) {
      return "cookie";
    }

    return null;
  }

  public function isUserValidated()
  {
    if ( !isset( $_SESSION[ "jjs_user_id" ] ) && !isset( $_COOKIE[ "jiujitsuscout" ][ "user_login_token" ] ) ) {
      // No session or token; needs to log in
      return false;
    }
    return true;
  }

  public function logIn( $email, $password, $token_expiration = 604800 )
  {
    $user = $this->repo->getByEmail( $email );
    if ( password_verify( $password, $user->password ) ) {
      $this->setUserIDSession( $user->id );
      $token = $this->setUserLoginToken( $user->id, $token_expiration );
      $this->repo->updateTokenByID( $token, $user->id );

      return true;
    }
    return false;
  }

  public function logOut()
  {
    if ( session_status() != PHP_SESSION_NONE ) {
      session_unset();
      session_destroy();
    }
    if ( isset( $_COOKIE[ "jiujitsuscout" ][ "user_login_token" ] ) ) {
      unset( $_COOKIE[ "jiujitsuscout" ][ "user_login_token" ] );
    }
  }

  public function setUserIDSession( $id )
  {
    $_SESSION[ "jjs_user_id" ] = $id;
  }

  public function setUserLoginToken( $id, $expiration )
  {
    $token = md5( microtime() );
    $this->setUserLoginCookie( $token, $expiration );
    return $token;
  }

  public function setUserLoginCookie( $token, $expiration )
  {
    if ( isset( $_COOKIE[ "jiujitsuscout" ][ "user_login_token" ] ) ) {
      unset( $_COOKIE[ "jiujitsuscout" ][ "user_login_token" ] );
    }
    setcookie( "jiujitsuscout[user_login_token]", $token, $expiration, "/" );
  }

  public function setCurrentBusiness( $business_id )
  {
    $this->current_business_id = $business_id;
  }

  public function getCurrentBusiness()
  {
    return $this->current_business_id;
  }

  private function setUser( \Models\User $user )
  {
    $this->user = $user;
  }

  public function getUser()
  {
    if ( !isset( $this->user ) ) {
      throw new \Exception( "User is not set" );
    }
    return $this->user;
  }

}
