<?php

namespace Models\Services;

class OrderProductRepository extends Service
{
    public function create( $order_id, $product_id, $quantity )
    {
        $orderProduct = new \Models\OrderProduct();
        $orderProductMapper = new \Models\Mappers\OrderProductMapper( $this->container );
        $orderProduct->order_id = $order_id;
        $orderProduct->product_id = $product_id;
        $orderProduct->quantity = $quantity;
        $orderProductMapper->create( $orderProduct );

        return $orderProduct;
    }

    public function getAll()
    {
        $orderProductMapper = new \Models\Mappers\OrderProductMapper( $this->container );
        $orderProducts = $orderProductMapper->mapAll();

        return $orderProducts;
    }

    public function getByID( $id )
    {
        $orderProduct = new \Models\OrderProduct();
        $orderProductMapper = new \Models\Mappers\OrderProductMapper( $this->container );
        $orderProductMapper->mapFromID( $orderProduct, $id );

        return $orderProduct;
    }
}
