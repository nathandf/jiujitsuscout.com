<?php

namespace Helpers;

class EmailValidator
{
    public static function validate( $email_address )
    {
        if ( filter_var( $email_address, FILTER_VALIDATE_EMAIL ) === false ) {
            throw new \InvalidArgumentException( "\"$email_address\" is not a valid email address" );
        }
    }
}
