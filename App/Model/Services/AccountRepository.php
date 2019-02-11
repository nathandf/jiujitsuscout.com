<?php

namespace Model\Services;

use Model\Account;
use Model\Mappers\AccountMapper;

class AccountRepository extends Repository
{

    public function create( $account_type_id, $country, $currency, $timezone )
    {
        $mapper = $this->getMapper();
        $account = $mapper->build( $this->entityName );
        $account->account_type_id = $account_type_id;
        $account->country = $country;
        $account->currency = $currency;
        $account->timezone = $timezone;
        $mapper->create( $account );

        return $account;
    }

    public function getByID( $id )
    {
        $mapper = $this->getMapper();
        $account = $mapper->build( $this->entityName );
        $mapper->mapFromID( $account, $id );

        return $account;
    }

    public function getAll()
    {
        $mapper = $this->getMapper();
        $accounts = $mapper->mapAll();

        return $accounts;
    }

    public function getAllEmails()
    {
        $mapper = $this->getMapper();
        $emails = $mapper->getAllEmails();

        return $emails;
    }

    public function updatePrimaryUserIDByID( $user_id, $id )
    {
        $mapper = $this->getMapper();
        $mapper->updatePrimaryUserIDByID( $user_id, $id );
    }

    public function addAccountCreditByID( $id, $amount )
    {
        $mapper = $this->getMapper();
        $mapper->addAccountCreditByID( $id, $amount );
    }

    public function debitAccountByID( $id, $amount )
    {
        $mapper = $this->getMapper();
        $mapper->subtractAccountCreditByID( $id, $amount );
    }

    public function updateAccountTypeIDByID( $account_id, $account_type_id )
    {
        $mapper = $this->getMapper();
        $mapper->updateAccountTypeIDByID( $account_id, $account_type_id );
    }

}
