<?php

namespace Model\Services;

use Model\Account;
use Model\Mappers\AccountMapper;

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
        $accountMapper = new \Model\Mappers\AccountMapper( $this->container );
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

    public function addAccountCreditByID( $id, $amount )
    {
        $accountMapper = new AccountMapper( $this->container );
        $accountMapper->addAccountCreditByID( $id, $amount );
    }

    public function debitAccountByID( $id, $amount )
    {
        $accountMapper = new AccountMapper( $this->container );
        $accountMapper->subtractAccountCreditByID( $id, $amount );
    }

    public function updateAccountTypeIDByID( $account_id, $account_type_id )
    {
        $accountMapper = new AccountMapper( $this->container );
        $accountMapper->updateAccountTypeIDByID( $account_id, $account_type_id );
    }

}
