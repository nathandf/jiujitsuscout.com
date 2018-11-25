<?php

namespace Model\Mappers;

use Model\Business;

class BusinessMapper extends DataMapper
{

  public function create( \Model\Business $business )
  {
    $id = $this->insert(
                    "business",
                    [ "account_id", "business_name", "contact_name", "email", "phone_id", "country", "timezone" ],
                    [ $business->account_id, $business->business_name, $business->contact_name, $business->email, $business->phone_id, $business->country, $business->timezone ]
                  );
    $business->id = $id;
    return $business;
  }

  public function mapFromBusinessName( Business $business, $business_name )
  {
    $sql = $this->DB->prepare( 'SELECT * FROM business WHERE business_name = :business_name' );
    $sql->bindParam( ":business_name", $business_name );
    $sql->execute();
    $resp = $sql->fetch( \PDO::FETCH_ASSOC );
    $this->populate( $business, $resp );
    return $business;
  }

  public function mapFromID( Business $business, $id )
  {
    $sql = $this->DB->prepare( "SELECT * FROM business WHERE id = :id" );
    $sql->bindParam( ":id", $id );
    $sql->execute();
    $resp = $sql->fetch( \PDO::FETCH_ASSOC );
    $this->populate( $business, $resp );
    return $business;
  }

  public function mapFromSiteSlug( Business $business, $slug )
  {
    $sql = $this->DB->prepare( "SELECT * FROM business WHERE site_slug = :site_slug" );
    $sql->bindParam( ":site_slug", $slug );
    $sql->execute();
    $resp = $sql->fetch( \PDO::FETCH_ASSOC );
    $this->populate( $business, $resp );
    return $business;
  }

  public function mapAllFromAccountID( $account_id )
  {
    $entityFactory = $this->container->getService( "entity-factory" );
    $businesses = [];
    $sql = $this->DB->prepare( 'SELECT * FROM business WHERE account_id = :account_id' );
    $sql->bindParam( ":account_id", $account_id );
    $sql->execute();
    while ( $resp = $sql->fetch( \PDO::FETCH_ASSOC ) ) {
      $business = $entityFactory->build( "Business" );
      $this->populate( $business, $resp );
      $businesses[] = $business;
    }

    return $businesses;
  }

    public function mapAllFromDisciplineID( $discipline_id )
    {
        $entityFactory = $this->container->getService( "entity-factory" );
        $businesses = [];
        $sql = $this->DB->prepare( "SELECT * FROM business" );
        $sql->execute();

        while ( $resp = $sql->fetch( \PDO::FETCH_ASSOC ) ) {
            $business = $entityFactory->build( "Business" );
            $this->populate( $business, $resp );
            $discipline_ids = explode( ",", $business->discipline_ids );
            if ( in_array( $discipline_id, $discipline_ids ) ) {
                $businesses[] = $business;
            }
        }

        return $businesses;
    }

    public function mapAllFromLocalityAndRegion( $locality, $region )
    {
        $entityFactory = $this->container->getService( "entity-factory" );
        $businesses = [];
        $sql = $this->DB->prepare( "SELECT * FROM business WHERE city = :city AND region = :region" );
        $sql->bindParam( ":city", $locality );
        $sql->bindParam( ":region", $region );
        $sql->execute();

        while ( $resp = $sql->fetch( \PDO::FETCH_ASSOC ) ) {
            $business = $entityFactory->build( "Business" );
            $this->populate( $business, $resp );
            $businesses[] = $business;
        }

        return $businesses;
    }

    public function mapAll()
    {
        $entityFactory = $this->container->getService( "entity-factory" );
        $businesses = [];

        $sql = $this->DB->prepare( 'SELECT * FROM business' );
        $sql->execute();

        while ( $resp = $sql->fetch( \PDO::FETCH_ASSOC ) ) {
            $business = $entityFactory->build( "Business" );
            $this->populate( $business, $resp );
            $businesses[] = $business;
        }

        return $businesses;
    }

    public function getAllBusinessIDs()
    {
        $business_ids = [];
        $sql = $this->DB->prepare( "SELECT id FROM business" );
        $sql->execute();
        while ( $resp = $sql->fetch( \PDO::FETCH_ASSOC ) ) {
            $business_ids[] = $resp[ "id" ];
        }

        return $business_ids;
    }

  public function updateSiteSlugByID( $id, $slug )
  {
    $this->update( "business", "site_slug", $slug, "id", $id );
  }

  public function updateDisciplinesByID( $id, $disciplines )
  {
    $this->update( "business", "discipline_ids", $disciplines, "id", $id );
  }

  public function updateProgramsByID( $id, $programs )
  {
    $this->update( "business", "programs", $programs, "id", $id );
  }

    public function updateLocationByID( $id, $location_details )
    {
        $this->update( "business", "address_1", $location_details[ "address_1" ], "id", $id );
        $this->update( "business", "address_2", $location_details[ "address_2" ], "id", $id );
        $this->update( "business", "city", $location_details[ "city" ], "id", $id );
        $this->update( "business", "region", $location_details[ "region" ], "id", $id );
        $this->update( "business", "postal_code", $location_details[ "postal_code" ], "id", $id );
        $this->update( "business", "country", $location_details[ "country" ], "id", $id );
    }

    public function updateLatitudeLongitudeByID( $id, $latitude, $longitude )
    {
      $this->update( "business", "latitude", $latitude, "id", $id );
      $this->update( "business", "longitude", $longitude, "id", $id );
    }

    public function updateEmailByID( $id, $email )
    {
        $this->update( "business", "email", $email, "id", $id );
    }

    public function updateSiteMessageByID( $id, $title, $message )
    {
        $this->update( "business", "title", $title, "id", $id );
        $this->update( "business", "message", $message, "id", $id );
    }

    public function updateProfileCompleteByID( $id )
    {
        $this->update( "business", "profile_complete", 1, "id", $id );
    }

  public function updateVideoByID( $id, $video_link )
  {
    $this->update( "business", "video_link", $video_link, "id", $id );
  }

  public function updateFacebookPixelIDByID( $id, $facebook_pixel_id )
  {
    $this->update( "business", "facebook_pixel_id", $facebook_pixel_id, "id", $id );
  }

  public function updateLogoByID( $id, $logo_filename )
  {
    $this->update( "business", "logo_filename", $logo_filename, "id", $id );
  }

    public function updateUserNotificationRecipientIDsByID( $id, $user_ids )
    {
        $this->update( "business", "user_notification_recipient_ids", $user_ids, "id", $id );
    }

    public function updateVideoIDByID( $id, $video_id )
    {
        $this->update( "business", "video_id", $video_id, "id", $id );
    }

  public function getAllSiteSlugs()
  {
    $slugs = [];
    $sql = $this->DB->prepare( "SELECT site_slug FROM business" );
    $sql->execute();
    while ( $resp = $sql->fetch( \PDO::FETCH_ASSOC ) ) {
      $slugs[] = $resp[ "site_slug" ];
    }
    return $slugs;
  }

}
