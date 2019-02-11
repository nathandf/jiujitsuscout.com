<?php

namespace Model\Services;

class PasswordResetRepository extends Repository
{
    public function create( $email, $nonce_token_id )
    {
        $mapper = $this->getMapper();
        $passwordReset = $mapper->build( $this->entityName );
        $passwordReset->email = $email;
        $passwordReset->nonce_token_id = $nonce_token_id;
        $mapper->create( $passwordReset );

        return $passwordReset;
    }

    public function getAll()
    {
        $mapper = $this->getMapper();
        $passwordResets = $mapper->mapAll();

        return $passwordResets;
    }

    public function getByNonceTokenID( $nonce_token_id )
    {
        $mapper = $this->getMapper();
        $passwordReset = $mapper->build( $this->entityName );
        $mapper->mapFromNonceTokenID( $passwordReset, $nonce_token_id );

        return $passwordReset;
    }

}
