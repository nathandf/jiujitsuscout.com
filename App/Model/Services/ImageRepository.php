<?php

namespace Model\Services;

class ImageRepository extends Service
{
    public function create( $filename, $business_id = null, $description = null, $alt = null, $tags = null )
    {
        $image = new \Model\Image();
        $image->filename = $filename;
        $image->business_id = $business_id;
        $image->description = $description;
        $image->alt = $alt;
        $image->tags = $tags;
        $now = time();
        $image->created_at = $now;
        $image->updated_at = $now;

        $imageMapper = new \Model\Mappers\ImageMapper( $this->container );
        $imageMapper->create( $image );

        return $image;
    }

    public function getAllByBusinessID( $business_id )
    {
        $imageMapper = new \Model\Mappers\ImageMapper( $this->container );
        $images = $imageMapper->mapAllFromBusinessID( $business_id );

        return $images;
    }

    public function getByID( $id )
    {
        $image = new \Model\Image();
        $imageMapper = new \Model\Mappers\ImageMapper( $this->container );
        $imageMapper->mapFromID( $image, $id );

        return $image;
    }
}
