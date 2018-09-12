<?php

namespace Model\Mappers;

class ImageMapper extends DataMapper
{

    public function mapAllFromBusinessID( $business_id )
    {
        $entityFactory = $this->container->getService( "entity-factory" );
        $images = [];
        $sql = $this->DB->prepare( "SELECT * FROM images WHERE business_id = :business_id" );
        $sql->execute();
        while ( $resp = $sql->fetch( \PDO::FETCH_ASSOC ) ) {
            $image = $entityFactory->build( "Image" );
            $this->populateImage( $image, $resp );
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
