<?php

namespace Model\Services;

class BusinessRepository extends Repository
{

    public function create( $account_id, $business_name, $contact_name, $phone_id, $email, $country, $timezone )
    {
        $mapper = $this->getMapper();
        $business = $mapper->build( $this->entityName );
        $business->account_id = $account_id;
        $business->business_name = $business_name;
        $business->contact_name = $contact_name;
        $business->phone_id = $phone_id;
        $business->email = $email;
        $business->country = $country;
        $business->timezone = $timezone;
        $mapper->create( $business );

        return $business;
    }

    public function getAllBusinessIDs()
    {
        $mapper = $this->getMapper();
        $business_ids = $mapper->getAllBusinessIDs();

        return $business_ids;
    }

    public function getAllByDisciplineID( $discipline_id )
    {
        $mapper = $this->getMapper();
        $businesses = $mapper->mapAllFromDisciplineID( $discipline_id );

        return $businesses;
    }

    public function getByBusinessName( $business_name )
    {
        $mapper = $this->getMapper();
        $business = $mapper->build( $this->entityName );
        $mapper->mapFromBusinessName( $business, $business_name );

        return $business;
    }

    public function getByID( $id )
    {
        $mapper = $this->getMapper();
        $business = $mapper->build( $this->entityName );
        $mapper->mapFromID( $business, $id );

        return $business;
    }

    public function getBySiteSlug( $slug )
    {
        $mapper = $this->getMapper();
        $business = $mapper->build( $this->entityName );
        $mapper->mapFromSiteSlug( $business, $slug );

        return $business;
    }

    public function getAllByAccountID( $id )
    {
        $mapper = $this->getMapper();
        $businesses = $mapper->mapAllFromAccountID( $id );

        return $businesses;
    }

    public function getAll()
    {
        $mapper = $this->getMapper();
        $businesses = $mapper->mapAll();

        return $businesses;
    }

    public function getAllByLocalityAndRegion( $locality, $region )
    {
        $mapper = $this->getMapper();
        $businesses = $mapper->mapAllFromLocalityAndRegion( $locality, $region );

        return $businesses;
    }


    public function updateSiteSlugByID( $id, $slug )
    {
        if ( $this->checkSiteSlugAvailability( $slug ) ) {
            $mapper = $this->getMapper();
            $business = $mapper->build( $this->entityName );
            $slug = $business->formatSiteSlug( $slug );
            $mapper->updateSiteSlugByID( $id, $slug );

            return true;
        }

        return false;
    }

    public function updateDisciplinesByID( $id, array $disciplines )
    {
        $mapper = $this->getMapper();
        $disciplines = implode( ",", $disciplines );
        $mapper->updateDisciplinesByID( $id, $disciplines );
    }

    public function updateProgramsByID( $id, array $programs )
    {
        $mapper = $this->getMapper();
        $programs = implode( ",", $programs );
        $mapper->updateProgramsByID( $id, $programs );
    }

    public function updateLocationByID( $id, array $location_details )
    {
        $mapper = $this->getMapper();
        $mapper->updateLocationByID( $id, $location_details );
    }

    public function updateLatitudeLongitudeByID( $id, $latitude, $longitude )
    {
        $mapper = $this->getMapper();
        $mapper->updateLatitudeLongitudeByID( $id, $latitude, $longitude );
    }

    public function updateEmailByID( $id, $email )
    {
        $mapper = $this->getMapper();
        $mapper->updateEmailByID( $id, $email );
    }

    public function updateSiteMessageByID( $id, $title, $message )
    {
        $mapper = $this->getMapper();
        $mapper->updateSiteMessageByID( $id, $title, $message );
    }

    public function updateVideoByID( $id, $video_link )
    {
        $mapper = $this->getMapper();
        $mapper->updateVideoByID( $id, $video_link );
    }

    public function updateFacebookPixelIDBYID( $facebook_pixel_id, $id )
    {
        $mapper = $this->getMapper();
        $mapper->updateFacebookPixelIDByID( $id, $facebook_pixel_id );
    }

    public function updateLogoByID( $id, $logo_filename )
    {
        $mapper = $this->getMapper();
        $mapper->updateLogoByID( $id, $logo_filename );
    }

    public function updateUserNotificationRecipientIDsByID( $id, array $user_ids )
    {
        $user_ids = implode( ",", $user_ids );
        $mapper = $this->getMapper();
        $mapper->updateUserNotificationRecipientIDsByID( $id, $user_ids );
    }

    public function updateProfileCompleteByID( $id )
    {
        $mapper = $this->getMapper();
        $mapper->updateProfileCompleteByID( $id );
    }

    public function updateVideoIDByID( $id, $video_id )
    {
        $mapper = $this->getMapper();
        $mapper->updateVideoIDByID( $id, $video_id );
    }

    public function updateWebsiteByID( $id, $website )
    {
        $mapper = $this->getMapper();
        $mapper->updateWebsiteIDByID( $id, $website );
    }

    public function getAllSiteSlugs()
    {
        $mapper = $this->getMapper();
        $slugs = $mapper->getAllSiteSlugs();

        return $slugs;
    }

    public function checkSiteSlugAvailability( $slug_to_check )
    {
        $unavailable_slugs = [];
        $slugs = $this->getAllSiteSlugs();
        foreach ( $slugs as $slug ) {
            $unavailable_slugs[] = $slug;
        }

        if ( !in_array( $slug_to_check, $unavailable_slugs ) ) {
            return true;
        }

        return false;
    }
}
