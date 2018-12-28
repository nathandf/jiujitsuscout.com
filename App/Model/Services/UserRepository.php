<?php

namespace Model\Services;

use Model\User;
use Model\Mappers\UserMapper;

class UserRepository extends Repository
{
    public function create( $account_id, $business_id, $first_name, $last_name, $phone_id, $email, $role, $password, $terms_conditions_agreement )
    {
        $mapper = $this->getMapper();
        $user = $mapper->build( $this->entityName );
        $user->account_id = $account_id;
        $user->current_business_id = $business_id;
        $user->first_name = $first_name;
        $user->last_name = $last_name;
        $user->phone_id = $phone_id;
        $user->email = $email;
        $user->role = $role;
        $user->password = $password;
        $user->terms_conditions_agreement = $terms_conditions_agreement;
        $mapper->create( $user );

        return $user;
    }

    public function getAll()
    {
        $mapper = $this->getMapper();
        $users = $mapper->mapAll();

        return $users;
    }

    public function getByID( $id )
    {
        $mapper = $this->getMapper();
        $user = $mapper->build( $this->entityName );
        $this->setMapper( $mapper );
        $mapper->mapFromID( $user, $id );

        return $user;
    }

    public function getAllByAccountID( $id )
    {
        $mapper = $this->getMapper();
        $users = $mapper->mapAllFromAccountID( $id );

        return $users;
    }

    public function getByEmail( $email )
    {
        $mapper = $this->getMapper();
        $user = $mapper->build( $this->entityName );
        $this->setMapper( $mapper );
        $mapper->mapFromEmail( $user, $email );

        return $user;
    }

    public function getByToken( $token )
    {
        $mapper = $this->getMapper();
        $user = $mapper->build( $this->entityName );
        $this->setMapper( $mapper );
        $mapper->mapFromToken( $token );

        return $user;
    }

    public function getAllEmails()
    {
        $mapper = $this->getMapper();
        $emails = $mapper->getAllEmails();

        return $emails;
    }

    public function save( User $user )
    {
        $required_properties = [ $user->first_name, $user->last_name, $user->email,
            $user->phone_id, $user->role, $user->account_id,
            $user->password
        ];

        foreach ( $required_properties as $properties ) {
            if ( !empty( $properties ) ) {
                return false;
            }
        }

        $mapper = $this->getMapper();
        $mapper->create( $user );

        return true;
    }

    public function updateUserByID( $id, \Model\User $user )
    {
        $mapper = $this->getMapper();
        $mapper->updateUserByID( $id, $user );
    }

    public function updateCurrentBusinessID( User $user )
    {
        $mapper = $this->getMapper();
        $mapper->updateCurrentBusinessIDbyID( $user->getCurrentBusinessID(), $user->id );

        return true;
    }

    public function updatePhoneIDByID( $phone_id, $id )
    {
        $mapper = $this->getMapper();
        $mapper->updatePhoneIDByID( $phone_id, $id );

        return true;
    }

    public function updateAddressIDByID( $address_id, $id )
    {
        $mapper = $this->getMapper();
        $mapper->updateAddressIDByID( $address_id, $id );

        return true;
    }

    public function updateTokenByEmail( $token, $email )
    {
        $mapper = $this->getMapper();
        $mapper->updateTokenByEmail( $token, $email );

        return true;
    }

    public function updatePasswordByID( $password, $id )
    {
        $hashed_password = password_hash( $password, PASSWORD_BCRYPT );

        $mapper = $this->getMapper();
        $mapper->updatePasswordByID( $hashed_password, $id );

        return true;
    }

    public function updateTokenByID( $token, $id )
    {
        $mapper = $this->getMapper();
        $mapper->updateTokenByID( $token, $id );

        return true;
    }

    public function updateRoleByID( $id, $role )
    {
        $mapper = $this->getMapper();
        $mapper->updateRoleByID( $id, $role );

        return true;
    }
}
