<?php

namespace Model\Mappers;

use Model\LandingPage;

class LandingPageMapper extends DataMapper
{
    public function create( LandingPage $landingPage )
    {
        $id = $this->insert(
            "landing_page",
            [ "name", "slug", "business_id", "group_ids", "facebook_pixel_id", "call_to_action", "call_to_action_form", "headline", "text_a", "text_b", "text_c", "text_form", "image_background", "image_a", "image_b", "image_c", "template_file" ],
            [ $landingPage->name, $landingPage->slug, $landingPage->business_id, $landingPage->group_ids, $landingPage->facebook_pixel_id, $landingPage->call_to_action, $landingPage->call_to_action_form, $landingPage->headline, $landingPage->text_a, $landingPage->text_b, $landingPage->text_c, $landingPage->text_form, $landingPage->image_background, $landingPage->image_a, $landingPage->image_b, $landingPage->image_c, $landingPage->template_file ]
        );
        $landingPage->id = $id;

        return $landingPage;
    }

    public function mapFromID( LandingPage $landingPage, $id )
    {
        $sql = $this->DB->prepare( "SELECT * FROM landing_page WHERE id = :id" );
        $sql->bindParam( ":id", $id );
        $sql->execute();
        $resp = $sql->fetch( \PDO::FETCH_ASSOC );
        $this->populate( $landingPage, $resp );

        return $landingPage;
    }

    public function mapFromSlugAndBusinessID( LandingPage $landingPage, $slug, $id )
    {
        $sql = $this->DB->prepare( "SELECT * FROM landing_page WHERE slug = :slug AND business_id = :business_id" );
        $sql->bindParam( ":slug", $slug );
        $sql->bindParam( ":business_id", $id );
        $sql->execute();
        $resp = $sql->fetch( \PDO::FETCH_ASSOC );
        $this->populate( $landingPage, $resp );

        return $landingPage;
    }

    public function mapAllFromBusinessID( $business_id )
    {
        $landingPages = [];
        $sql = $this->DB->prepare( 'SELECT * FROM landing_page WHERE business_id = :business_id' );
        $sql->bindParam( ":business_id", $business_id );
        $sql->execute();

        while ( $resp = $sql->fetch( \PDO::FETCH_ASSOC ) ) {
            $landingPage = $this->entityFactory->build( "LandingPage" );
            $this->populate( $landingPage, $resp );
            $landingPages[] = $landingPage;
        }

        return $landingPages;
    }

    public function mapAllSlugsFromBusinessID( $business_id )
    {
        $slugs = [];
        $sql = $this->DB->prepare( "SELECT slug FROM landing_page WHERE business_id = :business_id" );
        $sql->bindParam( ":business_id", $business_id );
        $sql->execute();

        while ( $resp = $sql->fetch( \PDO::FETCH_ASSOC ) ) {
            $slugs[] = $resp[ "slug" ];
        }

        return $slugs;
    }

    public function updateSlugByID( $slug, $id )
    {
        $this->update( "landing_page", "slug", $slug, "id", $id );
    }

    public function updateNameByID( $name, $id )
    {
        $this->update( "landing_page", "name", $name, "id", $id );
    }

    public function updateFacebookPixelIDByID( $facebook_pixel_id, $id )
    {
        $this->update( "landing_page", "facebook_pixel_id", $facebook_pixel_id, "id", $id );
    }

    public function updateGroupIDsByID( $group_ids, $id )
    {
        $this->update( "landing_page", "group_ids", $group_ids, "id", $id );
    }
}
