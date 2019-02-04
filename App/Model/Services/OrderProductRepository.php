<?php

namespace Model\Services;

class OrderProductRepository extends Repository
{
    public function create( $order_id, $product_id, $quantity, $description = null )
    {
        $mapper = $this->getMapper();
        $orderProduct = $mapper->build( $this->entityName );
        $orderProduct->order_id = $order_id;
        $orderProduct->product_id = $product_id;
        $orderProduct->quantity = $quantity;
        $orderProduct->description = $description;
        $mapper->create( $orderProduct );

        return $orderProduct;
    }

    public function getAll()
    {
        $mapper = $this->getMapper();
        $orderProducts = $mapper->mapAll();

        return $orderProducts;
    }

    public function getAllByOrderID( $order_id )
    {
        $mapper = $this->getMapper();
        $orderProducts = $mapper->mapAllFromOrderID( $order_id );

        return $orderProducts;
    }

    public function getByID( $id )
    {
        $mapper = $this->getMapper();
        $orderProduct = $mapper->build( $this->entityName );
        $mapper->mapFromID( $orderProduct, $id );

        return $orderProduct;
    }

    public function removeByID( $id )
    {
        $mapper = $this->getMapper();
        $mapper->delete( [ "id" ], [ $id ] );
    }
}
