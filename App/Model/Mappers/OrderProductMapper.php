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
            $this->populateOrderProduct( $orderProduct, $resp );
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
            $this->populateOrderProduct( $orderProduct, $resp );
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
        $this->populateOrderProduct( $orderProduct, $resp );

        return $orderProduct;
    }

    public function delete( $id )
    {
        $sql = $this->DB->prepare( "DELETE FROM order_product WHERE id = :id" );
        $sql->bindParam( ":id", $id );
        $sql->execute();
    }

    private function populateOrderProduct( \Model\OrderProduct $orderProduct, $data )
    {
        $orderProduct->id          = $data[ "id" ];
        $orderProduct->order_id    = $data[ "order_id" ];
        $orderProduct->product_id  = $data[ "product_id" ];
        $orderProduct->quantity    = $data[ "quantity" ];
        $orderProduct->description = $data[ "description" ];
    }

}
