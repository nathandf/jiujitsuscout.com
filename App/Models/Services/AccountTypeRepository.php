<?php

namespace Model\Services;

use Model\AccountType;
use Model\Mappers\AccountTypeMapper;

class AccountTypeRepository extends Service
{

    public function getAll()
    {

        $accountTypeMapper = new \Model\Mappers\AccountTypeMapper( $this->container );
        $accountTypes = $accountTypeMapper->mapAll();

        return $accountTypes;
    }

    public function getByID( $id )
    {
        $accountType = new AccountType();
        $accountTypeMapper = new AccountTypeMapper( $this->container );
        $accountTypeMapper->mapFromID( $accountType, $id );

        return $accountType;
    }

}
