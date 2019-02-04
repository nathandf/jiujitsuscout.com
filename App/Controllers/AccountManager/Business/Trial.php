<?php

namespace Controllers\AccountManager\Business;

use Core\Controller;

class Trial extends Controller
{
    private $accountRepo;
    private $account;
    private $businessRepo;
    private $business;
    private $userRepo;
    private $user;
    private $prospectRepo;

    public function before()
    {
        // Loading services
        $userAuth = $this->load( "user-authenticator" );
        $accountRepo = $this->load( "account-repository" );
        $accountUserRepo = $this->load( "account-user-repository" );
        $businessRepo = $this->load( "business-repository" );
        $userRepo = $this->load( "user-repository" );
        $phoneRepo = $this->load( "phone-repository" );
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
        // Load prospects by type associated with business
        $this->prospectRepo = $this->load( "prospect-repository" );
        $this->leads = $this->prospectRepo->getAllByStatusAndBusinessID( "pending", $this->business->id );
        // Assign phone asset to lead
        foreach ( $this->leads as $lead ) {
            $phone = $phoneRepo->getByID( $lead->phone_id );
            $lead->phone_number = "+" . $phone->country_code . " " . $phone->national_number;
        }

        // Track with facebook pixel
		$Config = $this->load( "config" );
		$facebookPixelBuilder = $this->load( "facebook-pixel-builder" );

		$facebookPixelBuilder->addPixelID( $Config::$configs[ "facebook" ][ "jjs_pixel_id" ] );
		$this->view->assign( "facebook_pixel", $facebookPixelBuilder->build() );

        // Set data for the view
        $this->view->assign( "leads", $this->leads );
        $this->view->assign( "account", $this->account );
        $this->view->assign( "user", $this->user );
        $this->view->assign( "business", $this->business );
    }

    public function indexAction()
    {
        $this->view->redirect( "account-manager/business/trial/new" );
    }

    public function newAction()
    {
        $this->view->setTemplate( "account-manager/business/trial/choose-prospect.tpl" );
        $this->view->render( "App/Views/AccountManager/Business/Trial.php" );
    }

    public function detailsAction()
    {
        $input = $this->load( "input" );
        $inputValidator = $this->load( "input-validator" );
        $prospectRepo = $this->load( "prospect-repository" );

        // require prospect_id to be set in the query string
        if ( $input->exists( "get" ) && $input->issetField( "prospect_id" ) ) {
			// Verfiy that this business owns this prospect
			$prospects = $prospectRepo->getAllByBusinessID( $this->business->id );
			$prospect_ids = [];
			foreach ( $prospects as $prospect ) {
				$prospect_ids[] = $prospect->id;
			}
			if ( !in_array( $input->get( "prospect_id" ), $prospect_ids ) ) {
				$this->view->redirect( "account-manager/business/trial/new" );
			}
			// Load propsect
            $prospect = $prospectRepo->getByID( $input->get( "prospect_id" ) );
        } else {
            $this->view->redirect( "account-manager/business/trial/new" );
        }

        if ( $input->issetField( "add_trial" ) && $inputValidator->validate(

				$input,

				[
					"token" => [
						"equals-hidden" => $this->session->getSession( "csrf-token" ),
						"required" => true
					],
					"prospect_id" => [
						"name" => "Prospect ID",
						"required" => true
					],
					"StartDateMonth" => [
						"name" => "Start Date: Month",
						"required" => true
					],
					"StartDateDay" => [
						"name" => "Start Date: Day",
						"required" => true
					],
					"StartDateYear" => [
						"name" => "Start Date: Year",
						"required" => true
					],
					"EndDateMonth" => [
						"name" => "End Date: Month"
					],
					"EndDateDay" => [
						"name" => "End Date: Day"
					],
					"EndDateYear" => [
						"name" => "End Date: Year"
					],
					"quantity" => [
						"name" => "Quantity"
					],
					"unit" => [
						"name" => "Unit"
					]
				],

				"add_trial"
			) )
		{
            if ( !$input->issetField( "specific_end_date" ) ) {
                $input->addField( "specific_end_date", false );
            }

            $prospect_id = $input->get( "prospect_id" );
            $start_month = $input->get( "StartDateMonth" );
            $start_day = $input->get( "StartDateDay" );
            $start_year = $input->get( "StartDateYear" );
            $end_month = $input->get( "EndDateMonth" );
            $end_day = $input->get( "EndDateDay" );
            $end_year = $input->get( "EndDateYear" );
            $quantity = $input->get( "quantity" );
            $unit = $input->get( "unit" );
            $specific_end_date = $input->get( "specific_end_date" );

            // timestamp for trial start date
            $trial_start_time_string = $start_month . "/" . $start_day . "/" . $start_year;

            if ( $specific_end_date ) {
                // specific date was selected
                $trial_start = strtotime( $trial_start_time_string );
                // timestamp for trial end date
                $trial_end_time_string = $end_month . "/" . $end_day . "/" . $end_year;
                $trial_end = strtotime( $trial_end_time_string );
            } else {
                $trial_start = strtotime( $trial_start_time_string );
                // trial length in seconds
                if ( $unit == "day" ) {
                    $trial_length = ( 60 * 60 * 24 ) * $quantity;
                } elseif ( $unit == "week" ) {
                    $trial_length = ( 60 * 60 * 24 * 7 ) * $quantity;
                } elseif ( $unit == "month" ) {
                    $trial_length = ( ( 60 * 60 * 24 ) * cal_days_in_month( CAL_GREGORIAN, $start_month, $start_year ) ) * $quantity;
                }
                // adding trial length to trial start time to get end time
                $trial_end = $trial_start + $trial_length;
            }

            $prospectRepo->updateTrialTimesByID( $prospect_id, $trial_start, $trial_end );
            $prospectRepo->updateTypeByID( "trial", $prospect_id );

            $this->view->redirect( "account-manager/business/lead/" . $prospect_id . "/" );
        }

        $this->view->assign( "prospect", $prospect );

		$this->view->assign( "csrf_token", $this->session->generateCSRFToken() );
		$this->view->setErrorMessages( $inputValidator->getErrors() );

        $this->view->setTemplate( "account-manager/business/trial/details.tpl" );
        $this->view->render( "App/Views/AccountManager/Business/Trial.php" );
    }

}
