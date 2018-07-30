<?php

namespace Models\Services;

class OrderProductRepository extends Service
{
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
