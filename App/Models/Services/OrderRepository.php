<?php

namespace Models\Services;

class OrderRepository extends Service
{
    public function create( $customer_id, $paid = 0 )
    {
        $order = new \Models\Order();
        $orderMapper = new \Models\Mappers\OrderMapper( $this->container );
        $order->customer_id = $customer_id;
        $order->paid = $paid;
        $orderMapper->create( $order );

        return $order;
    }

    public function getAll()
    {
        $orderMapper = new \Models\Mappers\OrderMapper( $this->container );
        $orders = $orderMapper->mapAll();

        return $orders;
    }

    public function getByID( $id )
    {
        $order = new \Models\Order();
        $orderMapper = new \Models\Mappers\OrderMapper( $this->container );
        $orderMapper->mapFromID( $order, $id );

        return $order;
    }

    public function getByCustomerID( $customer_id )
    {
        $order = new \Models\Order();
        $orderMapper = new \Models\Mappers\OrderMapper( $this->container );
        $orderMapper->mapFromCustomerID( $order, $customer_id );

        return $order;
    }
}
