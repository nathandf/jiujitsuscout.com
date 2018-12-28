<?php

namespace Model\Mappers;

class ImageMapper extends DataMapper
{
    public function create( \Model\Image $image )
    {
        $id = $this->insert(
            "image",
            [ "business_id", "filename", "description", "alt", "tags", "created_at", "updated_at" ],
            [ $image->business_id, $image->filename, $image->description, $image->alt, $image->tags, $image->created_at, $image->updated_at ]
        );

        return $image->id = $id;
    }

    public function mapFromID( \Model\Image $image, $id )
    {
        $sql = $this->DB->prepare( "SELECT * FROM image WHERE id = :id" );
        $sql->bindParam( ":id", $id );
        $sql->execute();
        $resp = $sql->fetch( \PDO::FETCH_ASSOC );
        $this->populate( $image, $resp );

        return $image;
    }

    public function mapAllFromBusinessID( $business_id )
    {
        
        $images = [];
        $sql = $this->DB->prepare( "SELECT * FROM image WHERE business_id = :business_id ORDER BY id DESC" );
        $sql->bindParam( "business_id", $business_id );
        $sql->execute();
        while ( $resp = $sql->fetch( \PDO::FETCH_ASSOC ) ) {
            $image = $this->entityFactory->build( "Image" );
            $this->populate( $image, $resp );
            $images[] = $image;
        }

        return $images;
    }

    private function populateImage( \Model\Image $image, $data )
    {
        $image->id                = $data[ "id" ];
        $image->business_id       = $data[ "business_id" ];
        $image->filename          = $data[ "filename" ];
        $image->description       = $data[ "description" ];
        $image->alt               = $data[ "alt" ];
        $image->tags              = $data[ "tags" ];
    }
}
