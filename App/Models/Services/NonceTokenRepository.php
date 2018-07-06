<?php

namespace Models\Services;

class NonceTokenRepository extends Service
{
    public function create( $expiration = 3600 )
    {
        $nonceToken = new \Models\NonceToken();
        $nonceTokenMapper = new \Models\Mappers\NonceTokenMapper( $this->container );
        $nonceToken->value = md5( microtime() . uniqid() );
        $nonceToken->expiration = time() + $expiration;
        $nonceTokenMapper->create( $nonceToken );

        return $nonceToken;
    }

    public function getAll()
    {
        $nonceTokenMapper = new \Models\Mappers\NonceTokenMapper( $this->container );
        $nonceTokens = $nonceTokenMapper->mapAll();

        return $nonceTokens;
    }

    public function getByID( $id )
    {
        $nonceToken = new \Models\NonceToken();
        $nonceTokenMapper = new \Models\Mappers\NonceTokenMapper( $this->container );
        $nonceTokenMapper->mapFromID( $nonceToken, $id );

        return $nonceToken;
    }

    public function getByValue( $value )
    {
        $nonceToken = new \Models\NonceToken();
        $nonceTokenMapper = new \Models\Mappers\NonceTokenMapper( $this->container );
        $nonceTokenMapper->mapFromValue( $nonceToken, $value );

        return $nonceToken;
    }

    public function removeByID( $id )
    {
        $nonceTokenMapper = new \Models\Mappers\NonceTokenMapper( $this->container );
        $nonceTokenMapper->deleteByID( $id );
    }

}
