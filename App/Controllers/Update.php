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
}
