<?php

namespace Models\Mappers;

class PasswordResetMapper extends DataMapper
{

    public function create( \Models\PasswordReset $passwordReset )
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
        $entityFactory = $this->container->getService( "entity-factory" );
        $passwordResets = [];
        $sql = $this->DB->prepare( "SELECT * FROM password_reset" );
        $sql->execute();

        while ( $resp = $sql->fetch( \PDO::FETCH_ASSOC ) ) {
            $passwordReset = $entityFactory->build( "PasswordReset" );
            $this->populatePasswordReset( $passwordReset, $resp );
            $passwordResets[] = $passwordReset;
        }

        return $passwordResets;
    }

    public function mapFromID( \Models\PasswordReset $passwordReset, $id )
    {
        $sql = $this->DB->prepare( "SELECT * FROM password_reset WHERE id = :id" );
        $sql->bindParam( ":id", $id );
        $sql->execute();
        $resp = $sql->fetch( \PDO::FETCH_ASSOC );
        $this->populatePasswordReset( $passwordReset, $resp );

        return $passwordReset;
    }

    public function mapFromNonceTokenID( \Models\PasswordReset $passwordReset, $nonce_token_id )
    {
        $sql = $this->DB->prepare( "SELECT * FROM password_reset WHERE nonce_token_id = :nonce_token_id" );
        $sql->bindParam( ":nonce_token_id", $nonce_token_id );
        $sql->execute();
        $resp = $sql->fetch( \PDO::FETCH_ASSOC );
        $this->populatePasswordReset( $passwordReset, $resp );

        return $passwordReset;
    }

    private function populatePasswordReset( \Models\PasswordReset $passwordReset, $data )
    {
        $passwordReset->id             = $data[ "id" ];
        $passwordReset->email          = $data[ "email" ];
        $passwordReset->nonce_token_id = $data[ "nonce_token_id" ];
    }

}
