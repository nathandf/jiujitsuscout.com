<?php

namespace Controllers\AccountManager\Business;

use Core\Controller;

class Schedules extends Controller
{

    public function before()
    {
        // Loading services
        $userAuth = $this->load( "user-authenticator" );
        $accountRepo = $this->load( "account-repository" );
        $accountUserRepo = $this->load( "account-user-repository" );
        $this->businessRepo = $this->load( "business-repository" );
        $userRepo = $this->load( "user-repository" );

        // If user not validated with session or cookie, send them to sign in
        if ( !$userAuth->userValidate() ) {
            $this->view->redirect( "account-manager/sign-in" );
        }

        // User is logged in. Get the user object from the UserAuthenticator service
        $this->user = $userAuth->getUser();

        // Get AccountUser reference
        $accountUser = $accountUserRepo->getByUserID( $this->user->id );

        // Grab account details
        $this->account = $accountRepo->getByID( $accountUser->account_id );

        // Grab business details
        $this->business = $this->businessRepo->getByID( $this->user->getCurrentBusinessID() );

        // Set data for the view
        $this->view->assign( "account", $this->account );
        $this->view->assign( "user", $this->user );
        $this->view->assign( "business", $this->business );
    }

    public function indexAction()
    {
        $scheduleRepo = $this->load( "schedule-repository" );

        $schedules = $scheduleRepo->getAllByBusinessID( $this->business->id );

        $this->view->assign( "schedules", $schedules );

        $this->view->setTemplate( "account-manager/business/schedules/home.tpl" );
        $this->view->render( "App/Views/AccountManager/Business/Settings.php" );
    }

}
