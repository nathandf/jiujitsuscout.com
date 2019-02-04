<?php

namespace Controllers\AccountManager\Business;

use Core\Controller;

class Campaign extends Controller
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
        $campaignRepo = $this->load( "campaign-repository" );
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
        $this->business = $businessRepo->getByID( $this->user->getCurrentBusinessID() );

        // Verify that this business owns this campaign
        $campaigns = $campaignRepo->getAllByBusinessID( $this->business->id );
        $campaign_ids = [];
        foreach ( $campaigns as $campaign ) {
            $campaign_ids[] = $campaign->id;
        }
        if ( isset( $this->params[ "id" ] ) && !in_array( $this->params[ "id" ], $campaign_ids ) ) {
            $this->view->redirect( "account-manager/business/campaigns/" );
        }

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
        if ( !$this->issetParam( "id" ) ) {
            $this->view->redirect( "account-manager/business/campaigns/" );
        }

        $campaignRepo = $this->load( "campaign-repository" );
        $campaign = $campaignRepo->getByID( $this->params[ "id" ] );

        $this->view->assign( "campaign", $campaign );

        $this->view->assign( "system_message_title", "Message Title" );
        $this->view->assign( "system_message_body", "Success Message Body" );

        $this->view->setTemplate( "account-manager/business/campaign/campaign.tpl" );
        $this->view->render( "App/Views/AccountManager/Business/Campaign.php" );
    }

    public function chooseCampaignTypeAction()
    {
        if ( $this->issetParam( "id" ) ) {
            $this->view->redirect( "account-manager/business/campaign/" . $this->params[ "id" ] . "/" );
        }

        $campaignTypeRepo = $this->load( "campaign-type-repository" );
        $campaign_types = $campaignTypeRepo->getAll();

        $this->view->assign( "campaign_types", $campaign_types );

        $this->view->setTemplate( "account-manager/business/campaign/choose-campaign-type.tpl" );
        $this->view->render( "App/Views/AccountManager/Business/Campaign.php" );

    }

    public function newAction()
    {
        if ( $this->issetParam( "id" ) ) {
            $this->view->redirect( "account-manager/business/campaign/" . $this->params[ "id" ] . "/" );
        }

        $input = $this->load( "input" );
        $inputValidator = $this->load( "input-validator" );
        $campaignTypeRepo = $this->load( "campaign-type-repository" );
        $campaignRepo = $this->load( "campaign-repository" );
        $salesAgentMailer = $this->load( "sales-agent-mailer" );
        $phoneRepo = $this->load( "phone-repository" );

        // Get this users phone resource and set phone number property of user object
        $phone = $phoneRepo->getByID( $this->user->phone_id );
        $this->user->phone_number = "+" . $phone->country_code . " " . $phone->national_number;

        $campaignTypeIds = [];
        $campaignTypes = $campaignTypeRepo->getAll();

        foreach ( $campaignTypes as $type ) {
            $campaignTypeIds[] = $type->id;
        }

        if ( $input->exists( "get" ) && $inputValidator->validate(

                $input,

                [
                    "campaign_type_id" => [
                        "required" => true,
                        "in_array" => $campaignTypeIds,
                     ]
                 ],

                 "choose_campaign" // error index
             ) )
        {

            if ( $input->issetField( "create_campaign" ) && $inputValidator->validate(

                    $input,

                    [
                        "token" => [
                            "equals-hidden" => $this->session->getSession( "csrf-token" ),
                            "required" => true
                        ],
                        "campaign_type_id" => [
                            "name" => "Campaign type",
                            "required" => true,
                            "in_array" => $campaignTypeIds
                        ],
                        "name" =>[
                            "name" => "Campaign Name",
                            "required" => true,
                            "min" => 1,
                            "max" => 50
                        ],
                        "description" => [
                            "name" => "Description",
                            "required" => true,
                            "min" => 1,
                            "max" => 1000
                        ],
                        "startMonth" => [
                            "required" => true
                        ],
                        "startDay" => [
                            "required" => true
                        ],
                        "startYear" => [
                            "required" => true
                        ],
                        "endDay" => [
                            "required" => true
                        ],
                        "endMonth" => [
                            "required" => true
                        ],
                        "endYear" => [
                            "required" => true
                        ]
                    ], "create_campaign" /* error index */
                ) )
            {
                $start_date = $input->get( "startYear" ) . "/" . $input->get( "startMonth" ) . "/" . $input->get( "startDay" );
                $start_date = strtotime( $start_date );
                $end_date = $input->get( "endYear" ) . "/" . $input->get( "endMonth" ) . "/" . $input->get( "endDay" );
                $end_date = strtotime( $end_date );

                $campaign = $campaignRepo->create( $this->account->id, $this->business->id, $input->get( "campaign_type_id" ), "pending", $input->get( "name" ), $input->get( "description" ), $start_date, $end_date, null );

                // Notify sales agent of new campaign order
                $campaign_type = $campaignTypeRepo->getByID( $input->get( "campaign_type_id" ) );
                $salesAgentMailer->sendCampaignOrderAlert( $this->user->first_name, $this->business->business_name, $campaign_type->name, $this->user->email, $this->user->phone_number );

                $this->view->redirect( "account-manager/business/campaign/" . $campaign->id . "/" );
            }

            $inputs = [];

            // update_landing_page
            if ( $input->issetField( "create_campaign" ) ) {
                $inputs[ "create_campaign" ][ "name" ] = $input->get( "name" );
                $inputs[ "create_campaign" ][ "description" ] = $input->get( "description" );
            }

            // Input values submitted from form
            $this->view->assign( "inputs", $inputs );

            $csrf_token = $this->session->generateCSRFToken();
            $this->view->assign( "csrf_token", $csrf_token );
            $this->view->setErrorMessages( $inputValidator->getErrors() );

            $this->view->assign( "campaign_type_id", $input->get( "campaign_type_id" ) );
            $this->view->setTemplate( "account-manager/business/campaign/new.tpl" );
            $this->view->render( "App/Views/AccountManager/Business/Campaign.php" );
        } else {
            $this->view->redirect( "account-manager/business/campaigns/" );
        }
    }
}
