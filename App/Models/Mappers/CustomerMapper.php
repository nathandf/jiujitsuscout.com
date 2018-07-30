<?php

namespace Models\Mappers;

class CustomerMapper extends DataMapper
{

    public function create( \Models\Customer $customer )
    {
        $id = $this->insert(
            "customer",
            [ "account_id" ],
            [ $customer->account_id ]
        );

        $customer->id = $id;

        return $customer;
    }

    public function mapAll()
    {
        $entityFactory = $this->container->getService( "entity-factory" );
        $customers = [];
        $sql = $this->DB->prepare( "SELECT * FROM customer" );
        $sql->execute();
        while ( $resp = $sql->fetch( \PDO::FETCH_ASSOC ) ) {
            $customer = $entityFactory->build( "Customer" );
            $this->populateCustomer( $customer, $resp );
            $customers[] = $customer;
        }

        return $customers;
    }

    public function mapFromID( \Models\Customer $customer, $id )
    {
        $sql = $this->DB->prepare( "SELECT * FROM customer WHERE id = :id" );
        $sql->bindParam( ":id", $id );
        $sql->execute();
        $resp = $sql->fetch( \PDO::FETCH_ASSOC );
        $this->populateCustomer( $customer, $resp );

        return $customer;
    }

    public function mapFromAccountID( \Models\Customer $customer, $account_id )
    {
        $sql = $this->DB->prepare( "SELECT * FROM customer WHERE account_id = :account_id" );
        $sql->bindParam( ":account_id", $account_id );
        $sql->execute();
        $resp = $sql->fetch( \PDO::FETCH_ASSOC );
        $this->populateCustomer( $customer, $resp );

        return $customer;
    }

    private function populateCustomer( \Models\Customer $customer, $data )
    {
        $customer->id          = $data[ "id" ];
        $customer->customer_id = $data[ "customer_id" ];
        $customer->paid        = $data[ "paid" ];
    }

}
