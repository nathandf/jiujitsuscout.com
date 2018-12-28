<?php

namespace Model\Services;

class ImageRepository extends Repository
{
    public function create( $filename, $business_id = null, $description = null, $alt = null, $tags = null )
    {
        $mapper = $this->getMapper();
        $image = $mapper->build( $this->entityName );
        $image->filename = $filename;
        $image->business_id = $business_id;
        $image->description = $description;
        $image->alt = $alt;
        $image->tags = $tags;
        $now = time();
        $image->created_at = $now;
        $image->updated_at = $now;

        $mapper->create( $image );

        return $image;
    }

    public function getAllByBusinessID( $business_id )
    {
        $mapper = $this->getMapper();
        $images = $mapper->mapAllFromBusinessID( $business_id );

        return $images;
    }

    public function getByID( $id )
    {
        $mapper = $this->getMapper();
        $image = $mapper->build( $this->entityName );
        $mapper->mapFromID( $image, $id );

        return $image;
    }
}
