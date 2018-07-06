<?php

namespace Controllers\AccountManager\Business;

use Core\Controller;

class Campaigns extends Controller
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
        $accountUser = $accountUserRepo->getByUserID( $this->user->id );
        // Grab account details
        $this->account = $accountRepo->getByID( $accountUser->account_id );
        // Grab business details
        $this->business = $businessRepo->getByID( $this->user->getCurrentBusinessID() );

        $this->view->assign( "account", $this->account );
        $this->view->assign( "user", $this->user );
        $this->view->assign( "business", $this->business );
    }

    public function indexAction()
    {
        $campaignRepo = $this->load( "campaign-repository" );
        $campaignTypeRepo = $this->load( "campaign-type-repository" );

        $campaigns = $campaignRepo->getAllByBusinessID( $this->business->id );

        // Assign a campaign type object to all campaigns
        foreach ( $campaigns as $campaign ) {
            $campaignType = $campaignTypeRepo->getByID( $campaign->campaign_type_id );
            $campaign->campaign_type = $campaignType;
        }

        $this->view->assign( "campaigns", $campaigns );

        $this->view->setTemplate( "account-manager/business/campaigns/home.tpl" );
        $this->view->render( "App/Views/AccountManager/Business/Campaigns.php" );
    }

}
