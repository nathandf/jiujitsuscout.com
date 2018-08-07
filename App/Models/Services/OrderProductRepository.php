<?php

namespace Models\Services;

class OrderProductRepository extends Service
{
    public function create( $order_id, $product_id, $quantity, $description = null )
    {
        $orderProduct = new \Models\OrderProduct();
        $orderProductMapper = new \Models\Mappers\OrderProductMapper( $this->container );
        $orderProduct->order_id = $order_id;
        $orderProduct->product_id = $product_id;
        $orderProduct->quantity = $quantity;
        $orderProduct->description = $description;
        $orderProductMapper->create( $orderProduct );

        return $orderProduct;
    }

    public function getAll()
    {
        $orderProductMapper = new \Models\Mappers\OrderProductMapper( $this->container );
        $orderProducts = $orderProductMapper->mapAll();

        return $orderProducts;
    }

    public function getAllByOrderID( $order_id )
    {
        $orderProductMapper = new \Models\Mappers\OrderProductMapper( $this->container );
        $orderProducts = $orderProductMapper->mapAllFromOrderID( $order_id );

        return $orderProducts;
    }

    public function getByID( $id )
    {
        $orderProduct = new \Models\OrderProduct();
        $orderProductMapper = new \Models\Mappers\OrderProductMapper( $this->container );
        $orderProductMapper->mapFromID( $orderProduct, $id );

        return $orderProduct;
    }

    public function removeByID( $id )
    {
        $orderProductMapper = new \Models\Mappers\OrderProductMapper( $this->container );
        $orderProductMapper->delete( $id );
    }
}
