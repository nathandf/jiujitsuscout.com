<?php

namespace Model\Mappers;

class OrderMapper extends DataMapper
{

    public function create( \Model\Order $order )
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
        
        $orders = [];
        $sql = $this->DB->prepare( "SELECT * FROM `order`" );
        $sql->execute();
        while ( $resp = $sql->fetch( \PDO::FETCH_ASSOC ) ) {
            $order = $this->entityFactory->build( "Order" );
            $this->populateOrder( $order, $resp );
            $orders[] = $order;
        }

        return $orders;
    }

    public function mapFromID( \Model\Order $order, $id )
    {
        $sql = $this->DB->prepare( "SELECT * FROM `order` WHERE id = :id" );
        $sql->bindParam( ":id", $id );
        $sql->execute();
        $resp = $sql->fetch( \PDO::FETCH_ASSOC );
        $this->populateOrder( $order, $resp );

        return $order;
    }

    public function mapFromCustomerID( \Model\Order $order, $customer_id )
    {
        $sql = $this->DB->prepare( "SELECT * FROM `order` WHERE customer_id = :customer_id" );
        $sql->bindParam( ":customer_id", $customer_id );
        $sql->execute();
        $resp = $sql->fetch( \PDO::FETCH_ASSOC );
        $this->populateOrder( $order, $resp );

        return $order;
    }

    public function mapFromCustomerIDAndPaid( \Model\Order $order, $customer_id, $paid )
    {
        $sql = $this->DB->prepare( "SELECT * FROM `order` WHERE customer_id = :customer_id AND paid = :paid" );
        $sql->bindParam( ":customer_id", $customer_id );
        $sql->bindParam( ":paid", $paid );
        $sql->execute();
        $resp = $sql->fetch( \PDO::FETCH_ASSOC );
        $this->populateOrder( $order, $resp );

        return $order;
    }

    public function updatePaidByID( $id, $paid )
    {
        $this->update( "`order`", "paid", $paid, "id", $id );
    }

    public function delete( $id )
    {
        $sql = $this->DB->prepare( "DELETE FROM `order` WHERE id = :id" );
        $sql->bindParam( ":id", $id );
        $sql->execute();
    }

    private function populateOrder( \Model\Order $order, $data )
    {
        $order->id          = $data[ "id" ];
        $order->customer_id = $data[ "customer_id" ];
        $order->paid        = $data[ "paid" ];
    }

}
