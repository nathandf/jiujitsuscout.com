<?php

namespace Models\Services;

class OrderRepository extends Service
{
    public function create( $customer_id, $paid = 0 )
    {
        $orderProduct = new \Models\OrderProduct();
        $orderProductMapper = new \Models\Mappers\OrderProductMapper( $this->container );
        $orderProduct->customer_id = $customer_id;
        $orderProduct->paid = $paid;
        $orderProductMapper->create( $orderProduct );

        return $orderProduct;
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
}
