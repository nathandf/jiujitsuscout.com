<?php

namespace Model\Mappers;

class AccountUserMapper extends DataMapper
{
    public function create( $account_id, $user_id )
    {
        $id = $this->insert( "account_user", [ "account_id", "user_id" ], [ $account_id, $user_id ] );
        return $id;
    }

    public function mapAll()
    {
        $accountUsers = [];
        $sql = $this->DB->prepare( "SELECT * FROM account_user" );
        $sql->execute();
        while ( $resp = $sql->fetch( \PDO::FETCH_ASSOC ) ) {
            $accountUser = $this->entityFactory->build( "AccountUser" );
            $this->populate( $accountUser, $resp );
            $accountUsers[] = $accountUser;
        }

        return $accountUsers;
    }

    public function mapFromID( \Model\AccountUser $accountUser, $id )
    {
        $sql = $this->DB->prepare( "SELECT * FROM account_user WHERE id = :id" );
        $sql->bindParam( ":id", $id );
        $sql->execute();
        $resp = $sql->fetch( \PDO::FETCH_ASSOC );
        $this->populate( $accountUser, $resp );

        return $accountUser;
    }

    public function mapFromUserID( \Model\AccountUser $accountUser, $user_id )
    {
        $sql = $this->DB->prepare( "SELECT * FROM account_user WHERE user_id = :user_id" );
        $sql->bindParam( ":user_id", $user_id );
        $sql->execute();
        $resp = $sql->fetch( \PDO::FETCH_ASSOC );
        $this->populate( $accountUser, $resp );

        return $accountUser;
    }

    public function mapAllFromAccountID( $account_id )
    {
        $accountUsers = [];
        $sql = $this->DB->prepare( 'SELECT * FROM account_user WHERE account_id = :account_id' );
        $sql->bindParam( ":account_id", $account_id );
        $sql->execute();

        while ( $resp = $sql->fetch( \PDO::FETCH_ASSOC ) ) {
            $accountUser = $this->entityFactory->build( "AccountUser" );
            $this->populate( $accountUser, $resp );
            $accountUsers[] = $accountUser;
        }

        return $accountUsers;
    }
}
