<?php

namespace Model\Mappers;

class CustomerMapper extends DataMapper
{

    public function create( \Model\Customer $customer )
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
        
        $customers = [];
        $sql = $this->DB->prepare( "SELECT * FROM customer" );
        $sql->execute();
        while ( $resp = $sql->fetch( \PDO::FETCH_ASSOC ) ) {
            $customer = $this->entityFactory->build( "Customer" );
            $this->populateCustomer( $customer, $resp );
            $customers[] = $customer;
        }

        return $customers;
    }

    public function mapFromID( \Model\Customer $customer, $id )
    {
        $sql = $this->DB->prepare( "SELECT * FROM customer WHERE id = :id" );
        $sql->bindParam( ":id", $id );
        $sql->execute();
        $resp = $sql->fetch( \PDO::FETCH_ASSOC );
        $this->populateCustomer( $customer, $resp );

        return $customer;
    }

    public function mapFromAccountID( \Model\Customer $customer, $account_id )
    {
        $sql = $this->DB->prepare( "SELECT * FROM customer WHERE account_id = :account_id" );
        $sql->bindParam( ":account_id", $account_id );
        $sql->execute();
        $resp = $sql->fetch( \PDO::FETCH_ASSOC );
        $this->populateCustomer( $customer, $resp );

        return $customer;
    }

    private function populateCustomer( \Model\Customer $customer, $data )
    {
        $customer->id         = $data[ "id" ];
        $customer->account_id = $data[ "account_id" ];
    }

}
