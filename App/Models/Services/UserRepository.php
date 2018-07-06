<?php

namespace Models\Services;

use Models\User;
use Models\Mappers\UserMapper;

class UserRepository extends Service
{

    public function create( $account_id, $business_id, $first_name, $last_name, $phone_id, $email, $role, $password, $terms_conditions_agreement )
    {
        $user = new User();
        $userMapper = new UserMapper( $this->container );
        $user->account_id = $account_id;
        $user->current_business_id = $business_id;
        $user->first_name = $first_name;
        $user->last_name = $last_name;
        $user->phone_id = $phone_id;
        $user->email = $email;
        $user->role = $role;
        $user->password = $password;
        $user->terms_conditions_agreement = $terms_conditions_agreement;
        $userMapper->create( $user );

        return $user;
    }

  public function getAll()
  {
    $userMapper = new \Models\Mappers\UserMapper( $this->container );
    $users = $userMapper->mapAll();
    return $users;
  }

  public function getByID( $id )
  {
    $user = new User();
    $userMapper = new UserMapper( $this->container );
    $this->setMapper( $userMapper );
    $userMapper->mapFromID( $user, $id );

    return $user;
  }

    public function getAllByAccountID( $id )
    {
        $userMapper = new \Models\Mappers\UserMapper( $this->container );
        $users = $userMapper->mapAllFromAccountID( $id );

        return $users;
    }

  public function getByEmail( $email )
  {
    $user = new User();
    $userMapper = new UserMapper( $this->container );
    $this->setMapper( $userMapper );
    $userMapper->mapFromEmail( $user, $email );
    return $user;
  }

  public function getByToken( $token )
  {
    $user = new User();
    $userMapper = new UserMapper( $this->container );
    $this->setMapper( $userMapper );
    $userMapper->mapFromToken( $token );
    return $user;
  }

    public function getAllEmails()
    {
        $userMapper = new UserMapper( $this->container );
        $emails = $userMapper->getAllEmails();

        return $emails;
    }

  public function save( User $user )
  {
    $required_properties = [ $user->first_name, $user->last_name, $user->email,
                             $user->phone_id, $user->role, $user->account_id,
                             $user->password ];
    foreach ( $required_properties as $properties ) {
      if ( !empty( $properties ) ) {
        return false;
      }
    }

    $userMapper = new UserMapper( $this->container );
    $userMapper->create( $user );

    return true;
  }

  public function updateUserByID( $id, \Models\User $user )
  {
    $userMapper = new \Models\Mappers\UserMapper( $this->container );
    $userMapper->updateUserByID( $id, $user );
  }

  public function updateCurrentBusinessID( User $user )
  {
    $userMapper = new UserMapper( $this->container );
    $userMapper->updateCurrentBusinessIDbyID( $user->getCurrentBusinessID(), $user->id );

    return true;
  }

  public function updatePhoneIDByID( $phone_id, $id )
  {
    $userMapper = new UserMapper( $this->container );
    $userMapper->updatePhoneIDByID( $phone_id, $id );

    return true;
  }

  public function updateAddressIDByID( $address_id, $id )
  {
    $userMapper = new UserMapper( $this->container );
    $userMapper->updateAddressIDByID( $address_id, $id );

    return true;
  }

  public function updateTokenByEmail( $token, $email )
  {
    $userMapper = new UserMapper( $this->container );
    $userMapper->updateTokenByEmail( $token, $email );

    return true;
  }

    public function updatePasswordByID( $password, $id )
    {
        $hashed_password = password_hash( $password, PASSWORD_BCRYPT );

        $userMapper = new UserMapper( $this->container );
        $userMapper->updatePasswordByID( $hashed_password, $id );

        return true;
    }

  public function updateTokenByID( $token, $id )
  {
    $userMapper = new UserMapper( $this->container );
    $userMapper->updateTokenByID( $token, $id );

    return true;
  }

}
