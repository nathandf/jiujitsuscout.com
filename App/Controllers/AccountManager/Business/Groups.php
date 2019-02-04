<?php

namespace Controllers\AccountManager\Business;

use Core\Controller;

class Groups extends Controller
{
    private $accountRepo;
    private $account;
    private $businessRepo;
    private $business;
    private $userRepo;
    private $user;

    public function before()
    {
        // Loading services
        $userAuth = $this->load( "user-authenticator" );
        $accountRepo = $this->load( "account-repository" );
        $accountUserRepo = $this->load( "account-user-repository" );
        $businessRepo = $this->load( "business-repository" );
        $userRepo = $this->load( "user-repository" );

        // If user not validated with session or cookie, send them to sign in
        if ( !$userAuth->userValidate() ) {
            $this->view->redirect( "account-manager/sign-in" );
        }

        // User is logged in. Get the user object from the UserAuthenticator service
        $this->user = $userAuth->getUser();

        // Get AccountUser reference
        $accountUser = $accountUserRepo->get( [ "*" ], [ "user_id" => $this->user->id ], "single" );

        // Grab account details
        $this->account = $accountRepo->get( [ "*" ], [ "id" => $accountUser->account_id ], "single" );

        // Grab business details
        $this->business = $businessRepo->get( [ "*" ], [ "id" => $this->user->getCurrentBusinessID() ], "single" );

        // Track with facebook pixel
		$Config = $this->load( "config" );
		$facebookPixelBuilder = $this->load( "facebook-pixel-builder" );

		$facebookPixelBuilder->addPixelID( $Config::$configs[ "facebook" ][ "jjs_pixel_id" ] );
		$this->view->assign( "facebook_pixel", $facebookPixelBuilder->buildPixel() );

        $this->view->assign( "account", $this->account );
        $this->view->assign( "user", $this->user );
        $this->view->assign( "business", $this->business );
    }

    public function indexAction()
    {
        $groupRepo = $this->load( "group-repository" );
        $groups = $groupRepo->get( [ "*" ], [ "business_id" => $this->business->id ] );

        $this->view->assign( "groups", $groups );
        $this->view->assign( "flash_messages", $this->session->getFlashMessages() );

        $this->view->setTemplate( "account-manager/business/groups/home.tpl" );
        $this->view->render( "App/Views/AccountManager/Business/Groups.php" );
    }
}
