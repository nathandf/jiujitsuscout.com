<?php

namespace Controllers\MartialArtsGyms;

use \Core\Controller;

class CaptureFollowUp extends Controller
{
    public function thankYouAction()
    {
        $this->requireParam( "id" );
        $this->requireParam( "slug" );

        $accountRepository = $this->load( "account-repository" );
        $businessRepo = $this->load( "business-repository" );
        $landingPageRepo = $this->load( "landing-page-repository" );
        $landingPageFacebookPixelRepo = $this->load( "landing-page-facebook-pixel-repository" );
        $facebookPixelRepo = $this->load( "facebook-pixel-repository" );
        $config = $this->load( "config" );
        $facebookPixelBuilder = $this->load( "facebook-pixel-builder" );

        $business = $businessRepo->get( [ "*" ], [ "id" => $this->params[ "id" ] ], "single" );

        if ( is_null( $business ) ) {
            $this->render404();
        }

        $landingPage = $landingPageRepo->get( [ "*" ], [ "business_id" => $business->id, "slug" => $this->params[ "slug" ] ], "single" );

        if ( is_null( $landingPage ) ) {
            $this->render404();
        }

        $landingPageFacebookPixels = $landingPageFacebookPixelRepo->get( [ "*" ], [ "landing_page_id" => $landingPage->id ] );

        // Add default JiuJitsuScout Pixel
        $facebook_pixel_ids = [ $config::$configs[ "facebook" ][ "jjs_pixel_id" ] ];
        foreach ( $landingPageFacebookPixels as $landingPageFacebookPixel ) {
            $facebookPixel = $facebookPixelRepo->get( [ "*" ], [ "id" => $landingPageFacebookPixel->facebook_pixel_id ], "single" );
            if ( !is_null( $facebookPixel ) ) {
                $facebook_pixel_ids[] = $facebookPixel->facebook_pixel_id;
            }
        }

        // Add facebook pixel ids to the facebook pixel code builder
        $facebookPixelBuilder->addPixelID( $facebook_pixel_ids );

        $facebookPixelBuilder->addEvent([
            "Lead"
        ]);

        $this->view->assign( "facebook_pixel", $facebookPixelBuilder->buildPixel() );
        $this->view->assign( "business", $business );

        $this->view->setTemplate( "martial-arts-gyms/landing-page/thank-you.tpl" );
        $this->view->render( "App/Views/MartialArtsGyms.php" );
    }
}
