<?php

namespace Model\Services;

class OrderRepository extends Repository
{
    public function create( $customer_id, $paid = 0 )
    {
        $mapper = $this->getMapper();
        $order = $mapper->build( $this->entityName );
        $order->customer_id = $customer_id;
        $order->paid = $paid;
        $mapper->create( $order );

        return $order;
    }

    public function getAll()
    {
        $mapper = $this->getMapper();
        $orders = $mapper->mapAll();

        return $orders;
    }

    public function getByID( $id )
    {
        $mapper = $this->getMapper();
        $order = $mapper->build( $this->entityName );
        $mapper->mapFromID( $order, $id );

        return $order;
    }

    public function getByCustomerID( $customer_id )
    {
        $mapper = $this->getMapper();
        $order = $mapper->build( $this->entityName );
        $mapper->mapFromCustomerID( $order, $customer_id );

        return $order;
    }

    public function getUnpaidOrderByCustomerID( $customer_id )
    {
        $mapper = $this->getMapper();
        $order = $mapper->build( $this->entityName );
        $mapper->mapFromCustomerIDAndPaid( $order, $customer_id, 0 );

        return $order;
    }

    public function updatePaidByID( $id, $paid )
    {
        $mapper = $this->getMapper();
        $mapper->updatePaidByID( $id, $paid );

        return true;
    }

    public function removeByID( $id )
    {
        $mapper = $this->getMapper();
        $mapper->delete( $id );
    }
}
