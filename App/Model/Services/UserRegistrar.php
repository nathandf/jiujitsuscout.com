<?php

namespace Model\Services;

class UserRegistrar
{

    public $userRepo;
    public $accountUserRepo;
    public $mailer;
    public $user;

    public function __construct( \Model\Services\UserRepository $userRepo, \Model\Services\AccountUserRepository $accountUserRepo, \Model\Services\UserMailer $mailer )
    {
        $this->userRepo = $userRepo;
        $this->mailer = $mailer;
        $this->accountUserRepo = $accountUserRepo;
    }

    public function register( $account_id, $business_id, $first_name, $last_name, $phone_id, $email, $role, $password, $terms_conditions_agreement  )
    {
        // Hash the password
        $hashed_password = password_hash( $password, PASSWORD_BCRYPT );

        if ( $terms_conditions_agreement != true ) {
            throw new \Exception( "An attempted manipulation of the agreement to the terms and conditions has taken place. Stop what you're doing. " );
        }

        $user = $this->userRepo->create( $account_id, $business_id, $first_name, $last_name, $phone_id, $email, $role, $hashed_password, $terms_conditions_agreement );
        $this->setUser( $user );

        // Create an accountUser reference
        $this->accountUserRepo->register( $account_id, $user->id );

        // Send a welcome email
        $this->mailer->sendWelcomeEmail( $user->first_name, $user->email );
    }

    public function setUser( $user )
    {
        $this->user = $user;
    }

    public function getUser()
    {
        if ( isset( $this->user ) ) {
            return $this->user;
        }

        return null;
    }

}
