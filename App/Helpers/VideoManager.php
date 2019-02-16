<?php

namespace Helpers;

class VideoManager
{

    public $new_video_file_name;
    public $new_video_type;
    public $video_name_iterator = 0;
    public $allowed_file_types = [ "video/mp4", "video/wma", "video/ogg" ];

    public function saveVideoTo( $index, $save_to_path = "public/videos/" )
    {
        if ( isset( $_FILES[ $index ] ) ) {
            $file_name      = $_FILES[ $index ][ "name" ];
            $file_type      = $_FILES[ $index ][ "type" ];
            $file_size      = $_FILES[ $index ][ "size" ];
            $file_tmp_name  = $_FILES[ $index ][ "tmp_name" ];

            if ( !in_array( $_FILES[ $index ][ "type" ], $this->allowed_file_types ) ) {
                return false;
            }

            $file_extension = $this->getFileExtension( $_FILES[ $index ][ "name" ] );
            $new_video_name = $this->buildUniqueVideoName( $file_extension );

            move_uploaded_file( $file_tmp_name, $save_to_path . $new_video_name  );
            $this->setNewVideoFileName( $new_video_name );
            $this->setNewVideoType( $_FILES[ $index ][ "type" ] );

            return $new_video_name;
        }

        return false;
    }

    public function overwriteVideo( $index, $path_to_old_video, $save_to_path = "public/videos/" )
    {
        if ( $this->saveVideoTo( $index, $save_to_path ) ) {
            $this->deleteVideo( $path_to_old_video );

            return $this->new_video_file_name;
        }

        return false;
    }

    public function getFileExtension( $path ) {
        $extension = pathinfo( $path, PATHINFO_EXTENSION );

        return $extension;
    }

    public function buildUniqueVideoName( $file_extension )
    {
        // the video_name_iterator added to the name in the event that multiple videos are being uploaded in quick succession
        $video_name = md5( time() ) . $this->video_name_iterator . "." . $file_extension;
        $this->video_name_iterator++;

        return $video_name;
    }

    public function deleteVideo( $path_to_video )
    {
        if ( file_exists( $path_to_video ) ) {
            @unlink( $path_to_video );
        }

        return true;
    }

    public function setNewVideoFileName( $name )
    {
        $this->new_video_file_name = $name;
    }

    public function getNewVideoFileName()
    {
        return $this->new_video_file_name;
    }

    public function setNewVideoType( $type )
    {
        $this->new_video_type = $type;
    }

    public function getNewVideoType()
    {
        return $this->new_video_type;
    }

}
