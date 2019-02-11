<?php

namespace Model\Services;

class CustomerRepository extends Repository
{
    public function create( $account_id )
    {
        $mapper = $this->getMapper();
        $customer = $mapper->build( $this->entityName );
        $customer->account_id = $account_id;
        $mapper->create( $customer );

        return $customer;
    }

    public function getAll()
    {
        $mapper = $this->getMapper();
        $customers = $mapper->mapAll();

        return $customers;
    }

    public function getByID( $id )
    {
        $mapper = $this->getMapper();
        $customer = $mapper->build( $this->entityName );
        $mapper->mapFromID( $customer, $id );

        return $customer;
    }

    public function getByAccountID( $account_id )
    {
        $mapper = $this->getMapper();
        $customer = $mapper->build( $this->entityName );
        $mapper->mapFromAccountID( $customer, $account_id );

        return $customer;
    }
}
