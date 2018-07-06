<?php

namespace Models\Services;

class AccountUserRepository extends Service
{

  public function register( $account_id, $user_id )
  {
    $accountUserMapper = new \Models\Mappers\AccountUserMapper( $this->container );
    $accountUserMapper->create( $account_id, $user_id );
  }

  public function getAll()
  {
    $accountUserMapper = new \Models\Mappers\AccountUserMapper( $this->container );
    $accountUsers = $accountUserMapper->mapAll();
    return $accountUsers;
  }

    public function getAllByAccountID( $id )
    {
        $accountUserMapper = new \Models\Mappers\AccountUserMapper( $this->container );
        $accountUsers = $accountUserMapper->mapAllFromAccountID( $id );

        return $accountUsers;
    }

  public function getByID( $id )
  {
    $accountUser = new \Models\AccountUser();
    $accountUserMapper = new \Models\Mappers\AccountUserMapper( $this->container );
    $accountUserMapper->mapFromID( $accountUser, $id );

    return $accountUser;
  }

  public function getByUserID( $id )
  {
    $accountUser = new \Models\AccountUser();
    $accountUserMapper = new \Models\Mappers\AccountUserMapper( $this->container );
    $accountUserMapper->mapFromUserID( $accountUser, $id );

    return $accountUser;
  }

}
