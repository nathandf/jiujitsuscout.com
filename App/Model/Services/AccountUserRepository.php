<?php

namespace Model\Services;

class AccountUserRepository extends Repository
{
    public function register( $account_id, $user_id )
    {
        $mapper = $this->getMapper();
        $mapper->create( $account_id, $user_id );
    }

    public function getAll()
    {
        $mapper = $this->getMapper();
        $accountUsers = $mapper->mapAll();

        return $accountUsers;
    }

    public function getAllByAccountID( $id )
    {
        $mapper = $this->getMapper();
        $accountUsers = $mapper->mapAllFromAccountID( $id );

        return $accountUsers;
    }

    public function getByID( $id )
    {
        $mapper = $this->getMapper();
        $accountUser = $mapper->build( $this->entityName );
        $mapper->mapFromID( $accountUser, $id );

        return $accountUser;
    }

    public function getByUserID( $id )
    {
        $mapper = $this->getMapper();
        $accountUser = $mapper->build( $this->entityName );
        $mapper->mapFromUserID( $accountUser, $id );

        return $accountUser;
    }
}
