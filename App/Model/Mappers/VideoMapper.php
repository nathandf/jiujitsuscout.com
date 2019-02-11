<?php

namespace Model\Mappers;

class VideoMapper extends DataMapper
{
    public function create( \Model\Video $video )
    {
        $id = $this->insert(
            "video",
            [ "business_id", "filename", "type", "name", "description", "created_at", "updated_at" ],
            [ $video->business_id, $video->filename, $video->type, $video->name, $video->description, $video->created_at, $video->updated_at ]
        );

        return $video->id = $id;
    }

    public function mapFromID( \Model\Video $video, $id )
    {
        $sql = $this->DB->prepare( "SELECT * FROM video WHERE id = :id" );
        $sql->bindParam( ":id", $id );
        $sql->execute();
        $resp = $sql->fetch( \PDO::FETCH_ASSOC );
        $this->populate( $video, $resp );

        return $video;
    }

    public function mapAllFromBusinessID( $business_id )
    {
        $videos = [];
        $sql = $this->DB->prepare( "SELECT * FROM video WHERE business_id = :business_id ORDER BY id DESC" );
        $sql->bindParam( "business_id", $business_id );
        $sql->execute();

        while ( $resp = $sql->fetch( \PDO::FETCH_ASSOC ) ) {
            $video = $this->entityFactory->build( "Video" );
            $this->populate( $video, $resp );
            $videos[] = $video;
        }

        return $videos;
    }

    public function deleteByID( $id )
    {
        $sql = $this->DB->prepare( "DELETE FROM video WHERE id = :id" );
        $sql->bindParam( ":id", $id );
        $sql->execute();
    }
}
