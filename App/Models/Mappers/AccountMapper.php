<?php

namespace Models\Mappers;

use Models\Account;

class AccountMapper extends DataMapper
{

    public function create( \Models\Account $account )
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
        $this->populateAccount( $account, $resp );

        return $account;
    }

    public function mapAll()
    {
        $entityFactory = $this->container->getService( "entity-factory" );
        $accounts = [];
        $sql = $this->DB->prepare( "SELECT * FROM account" );
        $sql->execute();

        while ( $resp = $sql->fetch( \PDO::FETCH_ASSOC ) ) {
            $account = $entityFactory->build( "Account" );
            $this->populateAccount( $account, $resp );
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

    private function populateAccount( \Models\Account $account, $data )
    {
        $account->id = $data[ "id" ];
        $account->account_status = $data[ "account_status" ];
        $account->account_type_id = $data[ "account_type_id" ];
        $account->currency = $data[ "currency" ];
        $account->country = $data[ "country" ];
        $account->profile_creation_date = $data[ "profile_creation_date" ];
        $account->timezone = $data[ "timezone" ];
    }

}
