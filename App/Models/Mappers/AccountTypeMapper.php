<?php

namespace Models\Mappers;

class AccountTypeMapper extends DataMapper
{

    public function mapAll()
    {
        $entityFactory = $this->container->getService( "entity-factory" );
        $accountTypes = [];
        $sql = $this->DB->prepare( "SELECT * FROM account_type" );
        $sql->execute();
        while ( $resp = $sql->fetch( \PDO::FETCH_ASSOC ) ) {
            $accountType = $entityFactory->build( "AccountType" );
            $this->populateAccountType( $accountType, $resp );
            $accountTypes[] = $accountType;
        }

        return $accountTypes;
    }

    public function mapFromID( \Models\AccountType $accountType, $id )
    {

        $sql = $this->DB->prepare( "SELECT * FROM account_type WHERE id = :id" );
        $sql->bindParam( ":id", $id );
        $sql->execute();
        $resp = $sql->fetch( \PDO::FETCH_ASSOC );
        $this->populateAccountType( $accountType, $resp );

        return $accountType;
    }

    public function populateAccountType( $accountType, $data )
    {
        $accountType->id               = $data[ "id" ];
        $accountType->name             = $data[ "name" ];
        $accountType->description      = $data[ "description" ];
        $accountType->max_users        = $data[ "max_users" ];
    }

}
