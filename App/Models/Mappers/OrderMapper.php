<?php

namespace Models\Mappers;

class OrderMapper extends DataMapper
{

    public function create( \Models\Order $order )
    {
        $id = $this->insert(
            "`order`",
            [ "customer_id", "paid" ],
            [ $order->customer_id, $order->paid ]
        );

        $order->id = $id;

        return $order;
    }

    public function mapAll()
    {
        $entityFactory = $this->container->getService( "entity-factory" );
        $orders = [];
        $sql = $this->DB->prepare( "SELECT * FROM `order`" );
        $sql->execute();
        while ( $resp = $sql->fetch( \PDO::FETCH_ASSOC ) ) {
            $order = $entityFactory->build( "Order" );
            $this->populateOrder( $order, $resp );
            $orders[] = $order;
        }

        return $orders;
    }

    public function mapFromID( \Models\Order $order, $id )
    {
        $sql = $this->DB->prepare( "SELECT * FROM `order` WHERE id = :id" );
        $sql->bindParam( ":id", $id );
        $sql->execute();
        $resp = $sql->fetch( \PDO::FETCH_ASSOC );
        $this->populateOrder( $order, $resp );

        return $order;
    }

    public function mapFromCustomerID( \Models\Order $order, $customer_id )
    {
        $sql = $this->DB->prepare( "SELECT * FROM `order` WHERE customer_id = :customer_id" );
        $sql->bindParam( ":customer_id", $customer_id );
        $sql->execute();
        $resp = $sql->fetch( \PDO::FETCH_ASSOC );
        $this->populateOrder( $order, $resp );

        return $order;
    }

    private function populateOrder( \Models\Order $order, $data )
    {
        $order->id          = $data[ "id" ];
        $order->customer_id = $data[ "customer_id" ];
        $order->paid        = $data[ "paid" ];
    }

}
