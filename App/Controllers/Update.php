<?php

namespace Controllers;

use \Core\Controller;

class Update extends Controller
{
	public function logosAction()
	{
		// TODO Update logo_image_id using the logo_filename property of the business
		$businessRepo = $this->load( "business-repository" );
		$imageRepo = $this->load( "image-repository" );

		$businesses = $businessRepo->get( [ "*" ] );

		foreach ( $businesses as $business ) {
			echo( $business->business_name . "<br>" );
			if (
				!is_null( $business->logo_filename ) &&
				$business->logo_filename != "default_logo.jpg" &&
				$business->logo_image_id == null
			) {
				$image = $imageRepo->get( [ "*" ], [ "filename" => $business->logo_filename ], "single" );
				if ( !is_null( $image ) ) {
					$businessRepo->update(
						[ "logo_image_id" => $image->id ],
						[ "id" => $business->id ]
					);
					echo( "logo image id updated<br>" );
				} else {
					$now = time();
					$image = $imageRepo->insert([
						"business_id" => $business->id,
						"filename" => $business->logo_filename,
						"created_at" => $now,
						"updated_at" => $now
					]);
					echo( "new image created - ID: {$image->id} - FILENAME: {$image->filename}<br>" );
					$businessRepo->update(
						[ "logo_image_id" => $image->id ],
						[ "id" => $business->id ]
					);
					echo( "logo image id updated<br>" );
				}
			} else {
				echo( "No logo or logo image id already exists" );
			}
			echo("<br><br>");
		}
	}

	public function facebookPixels()
	{
		$businessRepo = $this->load( "business-repository" );
		$facebookPixelRepo = $this->load( "facebook-pixel-repository" );
		$landingPageRepo = $this->load( "landing-page-repository" );
		$landingPageFacebookPixelRepo = $this->load( "landing-page-facebook-pixel-repository" );

		$businesses = $businessRepo->get( [ "*" ] );

		foreach ( $businesses as $business ) {
			if ( !is_null( $business->facebook_pixel_id ) ) {
				$facebookPixel = $facebookPixelRepo->insert([
					"business_id" => $business->id,
					"facebook_pixel_id" => $business->facebook_pixel_id,
					"name" => $business->business_name . " - Primary"
				]);

				$landingPages = $landingPageRepo->get( [ "*" ], [ "business_id" => $business->id ] );
				foreach ( $landingPages as $landingPage ) {
					if ( !is_null( $landingPage->facebook_pixel_id ) ) {
						$landingPageFacebookPixelRepo->insert([
							"landing_page_id" => $landingPage->id,
							"facebook_pixel_id" => $facebookPixel->id
						]);
					}
				}
			}
		}
	}

	public function addresses()
	{
		$businessRepo = $this->load( "business-repository" );
		$addressRepo = $this->load( "address-repository" );
		$countryRepo = $this->load( "country-repository" );

		$businesses = $businessRepo->get( [ "*" ] );

		foreach ( $businesses as $business ) {
			if ( is_null( $business->address_id ) ) {
				$country_id = null;
				$country_id_array = $countryRepo->get( [ "id" ], [ "iso" => $business->country ], "raw" );

				if ( !empty( $country_id_array ) ) {
					$country_id = $country_id_array[ 0 ];
				}

				$address = $addressRepo->insert([
					"address_1" => $business->address_1,
					"address_2" => $business->address_2,
					"city" => $business->city,
					"region" => $business->region,
					"postal_code" => $business->postal_code,
					"country_id" => $country_id
				]);

				$businessRepo->update( [ "address_id" => $address->id ], [ "id" => $business->id ] );
			}
		}
	}

	public function leadCaptures()
	{
		set_time_limit(1000);
		$leadCaptureRepo = $this->load( "lead-capture-repository" );
		$prospectRepo = $this->load( "prospect-repository" );

		$prospects = $prospectRepo->get( [ "*" ] );
		$non_jiujitsuscout_lead_sources = [ "referral", "unknown", "google", "other", null, "" ];
		foreach ( $prospects as $prospect ) {
			if ( !in_array( $prospect->source, $non_jiujitsuscout_lead_sources ) ) {
				$leadCaptureRepo->insert([
					"prospect_id" => $prospect->id
				]);
			}
		}
	}
}
