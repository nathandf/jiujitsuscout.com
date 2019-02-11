<?php

namespace Model\Mappers;

class ProductAccountTypeMapper extends DataMapper
{
    public function mapAll()
    {
        $productAccountTypes = [];
        $sql = $this->DB->prepare( "SELECT * FROM product_account_type" );
        $sql->execute();

        while ( $resp = $sql->fetch( \PDO::FETCH_ASSOC ) ) {
            $productAccountType = $this->entityFactory->build( "ProductAccountType" );
            $this->populate( $productAccountType, $resp );
            $productAccountTypes[] = $productAccountType;
        }

        return $productAccountTypes;
    }

    public function mapFromID( \Model\ProductAccountType $productAccountType, $id )
    {

        $sql = $this->DB->prepare( "SELECT * FROM product_account_type WHERE id = :id" );
        $sql->bindParam( ":id", $id );
        $sql->execute();
        $resp = $sql->fetch( \PDO::FETCH_ASSOC );
        $this->populate( $productAccountType, $resp );

        return $productAccountType;
    }

    public function mapFromProductID( \Model\ProductAccountType $productAccountType, $product_id )
    {
        $sql = $this->DB->prepare( "SELECT * FROM product_account_type WHERE product_id = :product_id" );
        $sql->bindParam( ":product_id", $product_id );
        $sql->execute();
        $resp = $sql->fetch( \PDO::FETCH_ASSOC );
        $this->populate( $productAccountType, $resp );

        return $productAccountType;
    }
}
