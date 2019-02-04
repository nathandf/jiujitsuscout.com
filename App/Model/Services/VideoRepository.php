<?php

namespace Model\Services;

class VideoRepository extends Repository
{
    public function create( $filename, $type, $business_id = null, $name = null, $description = null  )
    {
        $mapper = $this->getMapper();
        $video = $mapper->build( $this->entityName );
        $video->filename = $filename;
        $video->type = $type;
        $video->business_id = $business_id;
        $video->name = $name;
        $video->description = $description;
        $now = time();
        $video->created_at = $now;
        $video->updated_at = $now;

        $mapper->create( $video );

        return $video;
    }

    public function getAllByBusinessID( $business_id )
    {
        $mapper = $this->getMapper();
        $videos = $mapper->mapAllFromBusinessID( $business_id );

        return $videos;
    }

    public function getByID( $id )
    {
        $mapper = $this->getMapper();
        $video = $mapper->build( $this->entityName );
        $mapper->mapFromID( $video, $id );

        return $video;
    }

    public function removeByID( $id )
    {
        $mapper = $this->getMapper();
        $mapper->deleteByID( $id );
    }
}
