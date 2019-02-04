<?php

namespace Model\Mappers;

class AccountTypeMapper extends DataMapper
{
    public function mapAll()
    {

        $accountTypes = [];
        $sql = $this->DB->prepare( "SELECT * FROM account_type" );
        $sql->execute();
        while ( $resp = $sql->fetch( \PDO::FETCH_ASSOC ) ) {
            $accountType = $this->entityFactory->build( "AccountType" );
            $this->populate( $accountType, $resp );
            $accountTypes[] = $accountType;
        }

        return $accountTypes;
    }

    public function mapFromID( \Model\AccountType $accountType, $id )
    {

        $sql = $this->DB->prepare( "SELECT * FROM account_type WHERE id = :id" );
        $sql->bindParam( ":id", $id );
        $sql->execute();
        $resp = $sql->fetch( \PDO::FETCH_ASSOC );
        $this->populate( $accountType, $resp );

        return $accountType;
    }
}
