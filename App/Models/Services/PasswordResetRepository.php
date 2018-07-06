<?php

namespace Models\Services;

class PasswordResetRepository extends Service
{
    public function create( $email, $nonce_token_id )
    {
        $passwordReset = new \Models\PasswordReset();
        $passwordResetMapper = new \Models\Mappers\PasswordResetMapper( $this->container );
        $passwordReset->email = $email;
        $passwordReset->nonce_token_id = $nonce_token_id;
        $passwordResetMapper->create( $passwordReset );

        return $passwordReset;
    }

    public function getAll()
    {
        $passwordResetMapper = new \Models\Mappers\PasswordResetMapper( $this->container );
        $passwordResets = $passwordResetMapper->mapAll();

        return $passwordResets;
    }

    public function getByNonceTokenID( $nonce_token_id )
    {
        $passwordReset = new \Models\PasswordReset();
        $passwordResetMapper = new \Models\Mappers\PasswordResetMapper( $this->container );
        $passwordResetMapper->mapFromNonceTokenID( $passwordReset, $nonce_token_id );

        return $passwordReset;
    }

}
