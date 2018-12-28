<?php

namespace Model\Services;

use Model\AccountType;
use Model\Mappers\AccountTypeMapper;

class AccountTypeRepository extends Repository
{

    public function getAll()
    {
        $mapper = $this->getMapper();
        $accountTypes = $mapper->mapAll();

        return $accountTypes;
    }

    public function getByID( $id )
    {
        $mapper = $this->getMapper();
        $accountType = $mapper->build( $this->entityName );
        $mapper->mapFromID( $accountType, $id );

        return $accountType;
    }

}
