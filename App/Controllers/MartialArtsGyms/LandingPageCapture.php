<?php

namespace Controllers\MartialArtsGyms;

use \Core\Controller;

class LandingPageCapture extends Controller
{
    public function before()
    {
        $this->requireParam( "id" );
        $this->requireParam( "slug" );

        $accountRepository = $this->load( "account-repository" );
        $businessRepo = $this->load( "business-repository" );
        $landingPageRepo = $this->load( "landing-page-repository" );
        $landingPageFacebookPixelRepo = $this->load( "landing-page-facebook-pixel-repository" );
        $facebookPixelRepo = $this->load( "facebook-pixel-repository" );
        $config = $this->load( "config" );
        $this->facebookPixelBuilder = $this->load( "facebook-pixel-builder" );

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
        $this->facebookPixelBuilder->addPixelID( $facebook_pixel_ids );

        $this->view->assign( "business", $business );
    }

    public function after()
    {
        $this->view->render( "App/Views/MartialArtsGyms.php" );
    }

    public function thankYouAction()
    {
        $this->facebookPixelBuilder->addEvent([
            "Lead"
        ]);

        $this->view->assign( "facebook_pixel", $this->facebookPixelBuilder->buildPixel() );
        $this->view->setTemplate( "martial-arts-gyms/landing-page/thank-you.tpl" );
    }

    public function scheduleVisitAction()
    {
        $this->facebookPixelBuilder->addCustomEvent([
            "SelfSchedule"
        ]);

        $this->view->assign( "facebook_pixel", $this->facebookPixelBuilder->buildPixel() );
        $this->view->setTemplate( "martial-arts-gyms/landing-page/schedule.tpl" );
    }
}
