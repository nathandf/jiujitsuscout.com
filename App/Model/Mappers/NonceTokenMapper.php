<?php

namespace Model\Mappers;

class NonceTokenMapper extends DataMapper
{

    public function create( \Model\NonceToken $nonceToken )
    {
        $id = $this->insert(
            "nonce_token",
            [ "value", "expiration" ],
            [ $nonceToken->value, $nonceToken->expiration ]
        );

        $nonceToken->id = $id;

        return $nonceToken;
    }

    public function mapAll()
    {
        
        $nonceTokens = [];
        $sql = $this->DB->prepare( "SELECT * FROM nonce_token" );
        $sql->execute();

        while ( $resp = $sql->fetch( \PDO::FETCH_ASSOC ) ) {
            $nonceToken = $this->entityFactory->build( "NonceToken" );
            $this->populateNonceToken( $nonceToken, $resp );
            $nonceTokens[] = $nonceToken;
        }

        return $nonceTokens;
    }

    public function mapFromID( \Model\NonceToken $nonceToken, $id )
    {
        $sql = $this->DB->prepare( "SELECT * FROM nonce_token WHERE id = :id" );
        $sql->bindParam( ":id", $id );
        $sql->execute();
        $resp = $sql->fetch( \PDO::FETCH_ASSOC );
        $this->populateNonceToken( $nonceToken, $resp );

        return $nonceToken;
    }

    public function mapFromValue( \Model\NonceToken $nonceToken, $value )
    {
        $sql = $this->DB->prepare( "SELECT * FROM nonce_token WHERE value = :value" );
        $sql->bindParam( ":value", $value );
        $sql->execute();
        $resp = $sql->fetch( \PDO::FETCH_ASSOC );
        $this->populateNonceToken( $nonceToken, $resp );

        return $nonceToken;
    }

    public function deleteByID( $id )
    {
        $sql = $this->DB->prepare( "DELETE FROM nonce_token WHERE id = :id" );
        $sql->bindParam( ":id", $id );
        $sql->execute();
    }

    private function populateNonceToken( \Model\NonceToken $nonceToken, $data )
    {
        $nonceToken->id         = $data[ "id" ];
        $nonceToken->value      = $data[ "value" ];
        $nonceToken->expiration = $data[ "expiration" ];
    }

}
