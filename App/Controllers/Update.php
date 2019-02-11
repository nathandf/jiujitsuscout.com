<?php

namespace Controllers;

use \Core\Controller;

class Update extends Controller
{
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
}
