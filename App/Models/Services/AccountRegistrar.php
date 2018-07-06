<?php

namespace Models\Services;

class AccountRegistrar
{

    public $accountRepo;

    public function __construct( \Models\Services\AccountRepository $accountRepo )
    {
        $this->setAccountRepo( $accountRepo );
    }

    public function setAccountRepo( $accountRepo )
    {
        $this->accountRepo = $accountRepo;
    }

    public function register( $account_type_id, $country, $currency, $timezone )
    {
        $account = $this->accountRepo->create( $account_type_id, $country, $currency, $timezone );
        $this->setAccount( $account );
    }

    public function checkEmailAvailability( $email_to_check )
    {
        $unavailable_emails = [];
        $email_to_check = strtolower( $email_to_check );
        $emails = $this->accountRepo->getAllEmails();
        foreach ( $emails as $email ) {
            $unavailable_emails[] = strtolower( trim( $email ) );
        }

        if ( !in_array( $email_to_check, $unavailable_emails ) ) {

            return true;
        } else {

            return false;
        }
    }

    public function setAccount( \Models\Account $account )
    {
        $this->account = $account;
    }

    public function getAccount()
    {
        return $this->account;
    }

}
