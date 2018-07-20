<?php

namespace Models\Services;

use Models\Account;
use Models\Mappers\AccountMapper;

class AccountRepository extends Service
{

    public function create( $account_type_id, $country, $currency, $timezone )
    {
        $account = new Account();
        $accountMapper = new AccountMapper( $this->container );
        $account->account_type_id = $account_type_id;
        $account->country = $country;
        $account->currency = $currency;
        $account->timezone = $timezone;
        $accountMapper->create( $account );

        return $account;
    }

    public function getByID( $id )
    {
        $account = new Account();
        $accountMapper = new AccountMapper( $this->container );
        $accountMapper->mapFromID( $account, $id );

        return $account;
    }

    public function getAll()
    {
        $accountMapper = new \Models\Mappers\AccountMapper( $this->container );
        $accounts = $accountMapper->mapAll();

        return $accounts;
    }

    public function getAllEmails()
    {
        $accountMapper = new AccountMapper( $this->container );
        $emails = $accountMapper->getAllEmails();

        return $emails;
    }

    public function updatePrimaryUserIDByID( $user_id, $id )
    {
        $accountMapper = new AccountMapper( $this->container );
        $accountMapper->updatePrimaryUserIDByID( $user_id, $id );
    }

}
