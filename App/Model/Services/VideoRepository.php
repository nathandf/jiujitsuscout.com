<?php

namespace Model\Services;

class VideoRepository extends Service
{
    public function create( $filename, $type, $business_id = null, $description = null, $alt = null, $tags = null )
    {
        $video = new \Model\Video();
        $video->filename = $filename;
        $video->type = $type;
        $video->business_id = $business_id;
        $now = time();
        $video->created_at = $now;
        $video->updated_at = $now;

        $videoMapper = new \Model\Mappers\VideoMapper( $this->container );
        $videoMapper->create( $video );

        return $video;
    }

    public function getAllByBusinessID( $business_id )
    {
        $videoMapper = new \Model\Mappers\VideoMapper( $this->container );
        $videos = $videoMapper->mapAllFromBusinessID( $business_id );

        return $videos;
    }

    public function getByID( $id )
    {
        $video = new \Model\Video();
        $videoMapper = new \Model\Mappers\VideoMapper( $this->container );
        $videoMapper->mapFromID( $video, $id );

        return $video;
    }
}
