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
        $account->id = $resp[ "id" ];
        $account->account_status = $resp[ "account_status" ];
        $account->account_type_id = $resp[ "account_type_id" ];
        $account->currency = $resp[ "currency" ];
        $account->country = $resp[ "country" ];
        $account->profile_creation_date = $resp[ "profile_creation_date" ];
        $account->timezone = $resp[ "timezone" ];

        return $account;
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

}
