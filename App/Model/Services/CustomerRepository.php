<?php

namespace Model\Services;

class CustomerRepository extends Service
{
    public function create( $account_id )
    {
        $customer = new \Model\Customer();
        $customerMapper = new \Model\Mappers\CustomerMapper( $this->container );
        $customer->account_id = $account_id;
        $customerMapper->create( $customer );

        return $customer;
    }

    public function getAll()
    {
        $customerMapper = new \Model\Mappers\CustomerMapper( $this->container );
        $customers = $customerMapper->mapAll();

        return $customers;
    }

    public function getByID( $id )
    {
        $customer = new \Model\Customer();
        $customerMapper = new \Model\Mappers\CustomerMapper( $this->container );
        $customerMapper->mapFromID( $customer, $id );

        return $customer;
    }

    public function getByAccountID( $account_id )
    {
        $customer = new \Model\Customer();
        $customerMapper = new \Model\Mappers\CustomerMapper( $this->container );
        $customerMapper->mapFromAccountID( $customer, $account_id );

        return $customer;
    }
}
