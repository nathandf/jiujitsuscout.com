<?php

namespace Model\Services;

class BusinessRepository extends Service
{

    public function create( $account_id, $business_name, $contact_name, $phone_id, $email, $country, $timezone )
    {
        $business = new \Model\Business();
        $businessMapper = new \Model\Mappers\BusinessMapper( $this->container );
        $business->account_id = $account_id;
        $business->business_name = $business_name;
        $business->contact_name = $contact_name;
        $business->phone_id = $phone_id;
        $business->email = $email;
        $business->country = $country;
        $business->timezone = $timezone;
        $businessMapper->create( $business );

        return $business;
    }

    public function getAllBusinessIDs()
    {
        $businessMapper = new \Model\Mappers\BusinessMapper( $this->container );
        $business_ids = $businessMapper->getAllBusinessIDs();

        return $business_ids;
    }

  public function getAllByDisciplineID( $discipline_id )
  {
      $businessMapper = new \Model\Mappers\BusinessMapper( $this->container );
      $businesses = $businessMapper->mapAllFromDisciplineID( $discipline_id );

      return $businesses;
  }

  public function getByBusinessName( $business_name )
  {
    $business = new \Model\Business();
    $businessMapper = new \Model\Mappers\BusinessMapper( $this->container );
    $businessMapper->mapFromBusinessName( $business, $business_name );
    return $business;
  }

  public function getByID( $id )
  {
    $business = new \Model\Business();
    $businessMapper = new \Model\Mappers\BusinessMapper( $this->container );
    $businessMapper->mapFromID( $business, $id );
    return $business;
  }

  public function getBySiteSlug( $slug )
  {
    $business = new \Model\Business();
    $businessMapper = new \Model\Mappers\BusinessMapper( $this->container );
    $businessMapper->mapFromSiteSlug( $business, $slug );
    return $business;
  }

    public function getAllByAccountID( $id )
    {
        $businessMapper = new \Model\Mappers\BusinessMapper( $this->container );
        $businesses = $businessMapper->mapAllFromAccountID( $id );
        return $businesses;
    }

    public function getAll()
    {
        $businessMapper = new \Model\Mappers\BusinessMapper( $this->container );
        $businesses = $businessMapper->mapAll();

        return $businesses;
    }

    public function getAllByLocalityAndRegion( $locality, $region )
    {
        $businessMapper = new \Model\Mappers\BusinessMapper( $this->container );
        $businesses = $businessMapper->mapAllFromLocalityAndRegion( $locality, $region );

        return $businesses;
    }


  public function updateSiteSlugByID( $id, $slug )
  {
    if ( $this->checkSiteSlugAvailability( $slug ) ) {
      $business = new \Model\Business();
      $businessMapper = new \Model\Mappers\BusinessMapper( $this->container );
      $slug = $business->formatSiteSlug( $slug );
      $businessMapper->updateSiteSlugByID( $id, $slug );

      return true;
    }

    return false;
  }

  public function updateDisciplinesByID( $id, array $disciplines )
  {
    $disciplines = implode( ",", $disciplines );
    $businessMapper = new \Model\Mappers\BusinessMapper( $this->container );
    $businessMapper->updateDisciplinesByID( $id, $disciplines );
  }

  public function updateProgramsByID( $id, array $programs )
  {
    $programs = implode( ",", $programs );
    $businessMapper = new \Model\Mappers\BusinessMapper( $this->container );
    $businessMapper->updateProgramsByID( $id, $programs );
  }

  public function updateLocationByID( $id, array $location_details )
  {
    $businessMapper = new \Model\Mappers\BusinessMapper( $this->container );
    $businessMapper->updateLocationByID( $id, $location_details );
  }

    public function updateLatitudeLongitudeByID( $id, $latitude, $longitude )
    {
        $businessMapper = new \Model\Mappers\BusinessMapper( $this->container );
        $businessMapper->updateLatitudeLongitudeByID( $id, $latitude, $longitude );
    }

  public function updateEmailByID( $id, $email )
  {
    $businessMapper = new \Model\Mappers\BusinessMapper( $this->container );
    $businessMapper->updateEmailByID( $id, $email );
  }

  public function updateSiteMessageByID( $id, $title, $message )
  {
    $businessMapper = new \Model\Mappers\BusinessMapper( $this->container );
    $businessMapper->updateSiteMessageByID( $id, $title, $message );
  }

  public function updateVideoByID( $id, $video_link )
  {
    $businessMapper = new \Model\Mappers\BusinessMapper( $this->container );
    $businessMapper->updateVideoByID( $id, $video_link );
  }

    public function updateFacebookPixelIDBYID( $facebook_pixel_id, $id )
    {
        $businessMapper = new \Model\Mappers\BusinessMapper( $this->container );
        $businessMapper->updateFacebookPixelIDByID( $id, $facebook_pixel_id );
    }

  public function updateLogoByID( $id, $logo_filename )
  {
    $businessMapper = new \Model\Mappers\BusinessMapper( $this->container );
    $businessMapper->updateLogoByID( $id, $logo_filename );
  }

    public function updateUserNotificationRecipientIDsByID( $id, array $user_ids )
    {
        $user_ids = implode( ",", $user_ids );
        $businessMapper = new \Model\Mappers\BusinessMapper( $this->container );
        $businessMapper->updateUserNotificationRecipientIDsByID( $id, $user_ids );
    }

    public function updateProfileCompleteByID( $id )
    {
        $businessMapper = new \Model\Mappers\BusinessMapper( $this->container );
        $businessMapper->updateProfileCompleteByID( $id );
    }

  public function getAllSiteSlugs()
  {
    $businessMapper = new \Model\Mappers\BusinessMapper( $this->container );
    $slugs = $businessMapper->getAllSiteSlugs();
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
