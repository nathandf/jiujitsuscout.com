<?php

namespace Helpers;

class ImageManager
{

    public $new_image_file_name;
    public $image_name_iterator = 0;
    public $allowed_file_types = [ "image/jpg", "image/jpeg", "image/png", "image/gif" ];

    public function saveImageTo( $index, $save_to_path = "public/img/uploads/" )
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
            $new_image_name = $this->buildUniqueImageName( $file_extension );

            move_uploaded_file( $file_tmp_name, $save_to_path . $new_image_name  );
            $this->setNewImageFileName( $new_image_name );

            return $new_image_name;
        }

        return false;
    }

    public function overwriteImage( $index, $save_to_path, $path_to_old_image )
    {
        if ( $this->saveImageTo( $index, $save_to_path ) ) {
            $this->deleteImage( $path_to_old_image );

            return $this->new_image_file_name;
        }

        return false;
    }

    public function getFileExtension( $path ) {
        $extension = pathinfo( $path, PATHINFO_EXTENSION );

        return $extension;
    }

    public function buildUniqueImageName( $file_extension )
    {
        // the image_name_iterator added to the name in the event that multiple images are being uploaded in quick succession
        $image_name = md5( time() ) . $this->image_name_iterator . "." . $file_extension;
        $this->image_name_iterator++;

        return $image_name;
    }

    public function deleteImage( $path_to_image )
    {
        if ( file_exists( $path_to_image ) ) {
            @unlink( $path_to_image );
        }

        return true;
    }

    public function setNewImageFileName( $name )
    {
        $this->new_image_file_name = $name;
    }

    public function getNewImageFileName()
    {
        return $this->new_image_file_name;
    }

}
