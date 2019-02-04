<?php

namespace Model\Mappers;

class OrderProductMapper extends DataMapper
{
    public function create( \Model\OrderProduct $orderProduct )
    {
        $id = $this->insert(
            "order_product",
            [ "order_id", "product_id", "quantity", "description" ],
            [ $orderProduct->order_id, $orderProduct->product_id, $orderProduct->quantity, $orderProduct->description ]
        );

        $orderProduct->id = $id;

        return $orderProduct;
    }

    public function mapAll()
    {

        $orderProducts = [];
        $sql = $this->DB->prepare( "SELECT * FROM order_product" );
        $sql->execute();
        while ( $resp = $sql->fetch( \PDO::FETCH_ASSOC ) ) {
            $orderProduct = $this->entityFactory->build( "OrderProduct" );
            $this->populate( $orderProduct, $resp );
            $orderProducts[] = $orderProduct;
        }

        return $orderProducts;
    }

    public function mapAllFromOrderID( $order_id )
    {

        $orderProducts = [];
        $sql = $this->DB->prepare( "SELECT * FROM order_product WHERE order_id = :order_id" );
        $sql->bindParam( ":order_id", $order_id );
        $sql->execute();
        while ( $resp = $sql->fetch( \PDO::FETCH_ASSOC ) ) {
            $orderProduct = $this->entityFactory->build( "OrderProduct" );
            $this->populate( $orderProduct, $resp );
            $orderProducts[] = $orderProduct;
        }

        return $orderProducts;
    }

    public function mapFromID( \Model\OrderProduct $orderProduct, $id )
    {
        $sql = $this->DB->prepare( "SELECT * FROM order_product WHERE id = :id" );
        $sql->bindParam( ":id", $id );
        $sql->execute();
        $resp = $sql->fetch( \PDO::FETCH_ASSOC );
        $this->populate( $orderProduct, $resp );

        return $orderProduct;
    }
}
