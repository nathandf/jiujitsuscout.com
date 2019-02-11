<?php

namespace Model\Services;

class LandingPageRepository extends Repository
{
    public function create( $slug, $name, $business_id, array $group_ids, $facebook_pixel_id, $call_to_action, $call_to_action_form, $headline, $text_a, $text_b, $text_c, $text_form, $image_background, $image_a, $image_b, $image_c, $template_file )
    {
        $mapper = $this->getMapper();
        $landingPage = $mapper->build( $this->entityName );
        $landingPage->name = $name;
        $landingPage->slug = $landingPage->formatSlug( $slug );
        $landingPage->business_id = $business_id;
        $landingPage->group_ids = implode( ",", $group_ids );
        $landingPage->facebook_pixel_id = $facebook_pixel_id;
        $landingPage->call_to_action = $call_to_action;
        $landingPage->call_to_action_form = $call_to_action_form;
        $landingPage->headline = $headline;
        $landingPage->text_a = $text_a;
        $landingPage->text_b = $text_b;
        $landingPage->text_c = $text_c;
        $landingPage->text_form = $text_form;
        $landingPage->image_background = $image_background;
        $landingPage->image_a = $image_a;
        $landingPage->image_b = $image_b;
        $landingPage->image_c = $image_c;
        $landingPage->template_file = $template_file;
        $mapper->create( $landingPage );

        return $landingPage;
    }

    public function getByID( $id )
    {
        $mapper = $this->getMapper();
        $landingPage = $mapper->build( $this->entityName );
        $mapper->mapFromID( $landingPage, $id );

        return $landingPage;
    }

    public function getAllByBusinessID( $business_id )
    {
        $mapper = $this->getMapper();
        $landingPages = $mapper->mapAllFromBusinessID( $business_id );

        return $landingPages;
    }

    public function getBySlugAndBusinessID( $slug, $business_id )
    {
        $mapper = $this->getMapper();
        $landingPage = $mapper->build( $this->entityName );
        $mapper->mapFromSlugAndBusinessID( $landingPage, $slug, $business_id );

        return $landingPage;
    }

    public function getAllSlugsByBusinessID( $business_id )
    {
        $mapper = $this->getMapper();
        $slugs = $mapper->mapAllSlugsFromBusinessID( $business_id );

        return $slugs;
    }

    public function modifySlug( $slug, $landing_page_id, $business_id )
    {
        $mapper = $this->getMapper();
        $landingPage = $mapper->build( $this->entityName );
        $slug = $this->formatSlug( $slug );

        if ( $this->checkSlugAvailability( $slug, $business_id ) ) {
            $mapper->updateSlugByID( $slug, $landing_page_id );
        }
    }

    public function updateNameByID( $name, $id )
    {
        $mapper = $this->getMapper();
        $mapper->updateNameByID( $name, $id );
    }

    public function updateGroupIDsByID( $group_ids, $id )
    {
        $mapper = $this->getMapper();
        $mapper->updateGroupIDsByID( $group_ids, $id );
    }

    public function updateFacebookPixelIDByID( $facebook_pixel_id, $id )
    {
        $mapper = $this->getMapper();
        $mapper->updateFacebookPixelIDByID( $facebook_pixel_id, $id );
    }

    public function formatSlug( $slug )
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

    public function checkSlugAvailability( $slug_to_check, $business_id )
    {
        $slug_to_check = $this->formatSlug( $slug_to_check );
        $unavailable_slugs = [];
        $slugs = $this->getAllSlugsByBusinessID( $business_id );

        foreach ( $slugs as $slug ) {
            $unavailable_slugs[] = $slug;
        }

        if ( !in_array( $slug_to_check, $unavailable_slugs ) ) {
            return true;
        }

        return false;
    }
}
