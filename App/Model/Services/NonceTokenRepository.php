<?php

namespace Model\Services;

class NonceTokenRepository extends Repository
{
    public function create( $expiration = 3600 )
    {
        $mapper = $this->getMapper();
        $nonceToken = $mapper->build( $this->entityName );
        $nonceToken->value = md5( microtime() . uniqid() );
        $nonceToken->expiration = time() + $expiration;
        $mapper->create( $nonceToken );

        return $nonceToken;
    }

    public function getAll()
    {
        $mapper = $this->getMapper();
        $nonceTokens = $mapper->mapAll();

        return $nonceTokens;
    }

    public function getByID( $id )
    {
        $mapper = $this->getMapper();
        $nonceToken = $mapper->build( $this->entityName );
        $mapper->mapFromID( $nonceToken, $id );

        return $nonceToken;
    }

    public function getByValue( $value )
    {
        $mapper = $this->getMapper();
        $nonceToken = $mapper->build( $this->entityName );
        $mapper->mapFromValue( $nonceToken, $value );

        return $nonceToken;
    }

    public function removeByID( $id )
    {
        $mapper = $this->getMapper();
        $mapper->deleteByID( $id );
    }

}
