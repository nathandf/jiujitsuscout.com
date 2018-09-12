<?php

namespace Model\Services;

class ImageRepository extends Service
{
    public function getAllByBusinessID()
    {
        $imageMapper = new \Model\Mappers\ImageMapper( $this->container );
        $images = $imageMapper->mapAll();

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
