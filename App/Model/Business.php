<?php

namespace Model;

use Contracts\EntityInterface;

class Business implements EntityInterface
{
    public $video_id;
    public $logo_image_id;
    public $facebook_pixel_id;
    public $profile_complete;

    public function generateSiteSlug( $business_name, $id )
    {
        $site_slug = strtolower( str_replace( " ", "-", $business_name ) );
        $site_slug = $site_slug . "-" . $id;

        return $site_slug;
    }

    public function formatSiteSlug( $slug )
    {
        $slug = strtolower( $slug );
        // replace all spaces with hyphens
        $slug = preg_replace( "/[\s]/", "-", $slug );
        // replace all non-alphanumeric chars and underscores with nothing
        $slug = preg_replace( "/[^a-zA-Z0-9-]/", "", $slug );
        // replace double hypens with a single instance
        $slug = preg_replace( "/-+/", "-", $slug );

        return $slug;
    }

    public function getLatLonArray()
    {
        if ( !is_null( $this->latitude ) && !is_null( $this->longitude ) ) {
            return [ $this->latitude, $this->longitude ];
        }

        return [];
    }
}
