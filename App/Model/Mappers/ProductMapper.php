<?php

namespace Model\Mappers;

class ProductMapper extends DataMapper
{
    public function mapFromID( \Model\Product $product, $id )
    {
        $sql = $this->DB->prepare( "SELECT * FROM product WHERE id = :id" );
        $sql->bindParam( ":id", $id );
        $sql->execute();
        $resp = $sql->fetch( \PDO::FETCH_ASSOC );
        $this->populate( $product, $resp );

        return $product;
    }
}
