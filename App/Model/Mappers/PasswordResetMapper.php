<?php

namespace Model\Mappers;

class PasswordResetMapper extends DataMapper
{

    public function create( \Model\PasswordReset $passwordReset )
    {
        $id = $this->insert(
            "password_reset",
            [ "email", "nonce_token_id" ],
            [ $passwordReset->email, $passwordReset->nonce_token_id ]
        );

        $passwordReset->id = $id;

        return $passwordReset;
    }

    public function mapAll()
    {
        
        $passwordResets = [];
        $sql = $this->DB->prepare( "SELECT * FROM password_reset" );
        $sql->execute();

        while ( $resp = $sql->fetch( \PDO::FETCH_ASSOC ) ) {
            $passwordReset = $this->entityFactory->build( "PasswordReset" );
            $this->populatePasswordReset( $passwordReset, $resp );
            $passwordResets[] = $passwordReset;
        }

        return $passwordResets;
    }

    public function mapFromID( \Model\PasswordReset $passwordReset, $id )
    {
        $sql = $this->DB->prepare( "SELECT * FROM password_reset WHERE id = :id" );
        $sql->bindParam( ":id", $id );
        $sql->execute();
        $resp = $sql->fetch( \PDO::FETCH_ASSOC );
        $this->populatePasswordReset( $passwordReset, $resp );

        return $passwordReset;
    }

    public function mapFromNonceTokenID( \Model\PasswordReset $passwordReset, $nonce_token_id )
    {
        $sql = $this->DB->prepare( "SELECT * FROM password_reset WHERE nonce_token_id = :nonce_token_id" );
        $sql->bindParam( ":nonce_token_id", $nonce_token_id );
        $sql->execute();
        $resp = $sql->fetch( \PDO::FETCH_ASSOC );
        $this->populatePasswordReset( $passwordReset, $resp );

        return $passwordReset;
    }

    private function populatePasswordReset( \Model\PasswordReset $passwordReset, $data )
    {
        $passwordReset->id             = $data[ "id" ];
        $passwordReset->email          = $data[ "email" ];
        $passwordReset->nonce_token_id = $data[ "nonce_token_id" ];
    }

}
