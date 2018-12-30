<?php

namespace Model\Mappers;

use Model\Account;

class AccountMapper extends DataMapper
{
    public function create( \Model\Account $account )
    {
        $id = $this->insert(
            "account",
            [ "account_type_id", "country", "currency", "timezone" ],
            [ $account->account_type_id,  $account->country, $account->currency, $account->timezone ]
        );
        $account->id = $id;

        return $account;
    }

    public function mapFromID( Account $account, $id )
    {
        $sql = $this->DB->prepare( 'SELECT * FROM account WHERE id = :id' );
        $sql->bindParam( ":id", $id );
        $sql->execute();
        $resp = $sql->fetch( \PDO::FETCH_ASSOC );
        $this->populate( $account, $resp );

        return $account;
    }

    public function mapAll()
    {

        $accounts = [];
        $sql = $this->DB->prepare( "SELECT * FROM account" );
        $sql->execute();

        while ( $resp = $sql->fetch( \PDO::FETCH_ASSOC ) ) {
            $account = $this->entityFactory->build( "Account" );
            $this->populate( $account, $resp );
            $accounts[] = $account;
        }

        return $accounts;
    }

    public function getAllEmails()
    {
        $emails = [];
        $sql = $this->DB->prepare( "SELECT email FROM account" );
        $sql->execute();

        while ( $resp = $sql->fetch( \PDO::FETCH_ASSOC ) ) {
            $emails[] = $resp[ "email" ];
        }

        return $emails;
    }

    public function updatePrimaryUserIDByID( $user_id, $id )
    {
        $this->update( "account", "primary_user_id", $user_id, "id", $id );
    }

    public function addAccountCreditByID( $id, $amount )
    {
        $sql = $this->DB->prepare( "UPDATE account SET credit = credit + :credit WHERE id = :id" );
        $sql->bindParam( ":credit", $amount );
        $sql->bindParam( ":id", $id );
        $sql->execute();
    }

    public function subtractAccountCreditByID( $id, $amount )
    {
        $amount = floatval( $amount );
        $sql = $this->DB->prepare( "UPDATE account SET credit = ( credit - :amount ) WHERE id = :id" );
        $sql->bindParam( ":amount", $amount );
        $sql->bindParam( ":id", $id );
        $sql->execute();
    }

    public function updateAccountTypeIDByID( $account_id, $account_type_id )
    {
        $this->update( "account", "account_type_id", $account_type_id, "id", $account_id );
    }

    public function updateAutoPurchaseByID( $account_id, $value )
    {
        $this->update( "account", "auto_purchase", $value, "id", $account_id );
    }
}
