<?php

namespace Models\Services;

class OrderRepository extends Service
{
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
