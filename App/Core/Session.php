<?php

namespace Core;

class Session
{

    private $crsf_token;
    public $flash_messages = [];

    public function __construct()
    {
        // session
        if ( session_status() == PHP_SESSION_NONE ) {
            session_start();
        }
    }

    public function setSession( $index, $value )
    {
        $_SESSION[ $index ] = $value;
    }

    public function getSession( $index )
    {
        if ( isset( $_SESSION[ $index ] ) ) {
            return $_SESSION[ $index ];
        }

        return null;
    }

    public function addFlashMessage( $message )
    {
        $this->flash_messages[] = $message;
    }

    public function setFlashMessages()
    {
        $this->setSession( "flash_messages", $this->flash_messages );
    }

    public function getFlashMessages()
    {
        if ( isset( $_SESSION[ "flash_messages" ] ) ) {
            $flash_messages = $_SESSION[ "flash_messages"];
            unset( $_SESSION[ "flash_messages" ] );

            return $flash_messages;
        }

        return [];
    }

    public function generateCSRFToken()
    {
        $csrf_token = $this->generateToken();
        $this->setSession( "csrf-token", $csrf_token );

        return $csrf_token;
    }

    public function getCSRFToken()
    {
        return $this->crsf_token;
    }

    public function setCookie( $index, $value, $time = 86400 )
    {
        setcookie( $index, $value, time() + $time, null, null, false, false );
    }

    public function getCookie( $index )
    {
        if ( isset( $_COOKIE[ $index ] ) ) {
            return $_COOKIE[ $index ];
        }

        return null;
    }

    public function getCookieToken( $index )
    {
        if ( isset( $_COOKIE[ $index ] ) ) {
            return $_COOKIE[ $index ];
        }

        return null;
    }

    public function generateToken()
    {
        return hash( "md5", base64_encode( openssl_random_pseudo_bytes( 32 ) ) );
    }

}
