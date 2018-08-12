<?php

namespace Model\Services;

class OrderRepository extends Service
{
    public function create( $customer_id, $paid = 0 )
    {
        $order = new \Model\Order();
        $orderMapper = new \Model\Mappers\OrderMapper( $this->container );
        $order->customer_id = $customer_id;
        $order->paid = $paid;
        $orderMapper->create( $order );

        return $order;
    }

    public function getAll()
    {
        $orderMapper = new \Model\Mappers\OrderMapper( $this->container );
        $orders = $orderMapper->mapAll();

        return $orders;
    }

    public function getByID( $id )
    {
        $order = new \Model\Order();
        $orderMapper = new \Model\Mappers\OrderMapper( $this->container );
        $orderMapper->mapFromID( $order, $id );

        return $order;
    }

    public function getByCustomerID( $customer_id )
    {
        $order = new \Model\Order();
        $orderMapper = new \Model\Mappers\OrderMapper( $this->container );
        $orderMapper->mapFromCustomerID( $order, $customer_id );

        return $order;
    }

    public function getUnpaidOrderByCustomerID( $customer_id )
    {
        $order = new \Model\Order();
        $orderMapper = new \Model\Mappers\OrderMapper( $this->container );
        $orderMapper->mapFromCustomerIDAndPaid( $order, $customer_id, 0 );

        return $order;
    }

    public function updatePaidByID( $id, $paid )
    {
        $orderMapper = new \Model\Mappers\OrderMapper( $this->container );
        $orderMapper->updatePaidByID( $id, $paid );

        return true;
    }

    public function removeByID( $id )
    {
        $orderMapper = new \Model\Mappers\OrderMapper( $this->container );
        $orderMapper->delete( $id );
    }
}
