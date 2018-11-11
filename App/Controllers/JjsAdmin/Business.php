<?php

namespace Controllers\JjsAdmin;

use Core\Controller;

class Business extends Controller
{
    private $business;

    public function before()
    {
        $this->requireParam( "id" );

        // Loading services
		$userAuth = $this->load( "user-authenticator" );
		$userRepo = $this->load( "user-repository" );
        $accountRepo = $this->load( "account-repository" );
        $accountTypeRepo = $this->load( "account-type-repository" );
        $businessRepo = $this->load( "business-repository" );

        $business_ids = [];

        // Get all businesses
        $businesses = $businessRepo->getAll();
        foreach ( $businesses as $business ) {
            $business_ids[] = $business->id;
        }

        // Verify that current business id actually belongs to a business in the database
        if ( !in_array( $this->params[ "id" ], $business_ids ) ) {
            $this->view->redirect( "jjs-admin/businesses" );
        }

		// If user not validated with session or cookie, send them to sign in
		if ( !$userAuth->userValidate( [ "jjs-admin" ] ) ) {
			$this->view->redirect( "jjs-admin/sign-in" );
		}
		// User is logged in. Get the user object from the UserAuthenticator service
		$this->user = $userAuth->getUser();

        // Load business data
        $this->business = $businessRepo->getByID( $this->params[ "id" ] );

        // Load account associated with this business
        $this->account = $accountRepo->getByID( $this->business->account_id );

        // Load account type associated with this account
        $this->account_type = $accountTypeRepo->getByID( $this->account->account_type_id );

        // Set data for the view
        $this->view->assign( "account", $this->account );
        $this->view->assign( "account_type", $this->account_type );
        $this->view->assign( "business", $this->business );
    }

    public function indexAction()
    {
        // Load services
        $input = $this->load( "input" );
        $inputValidator = $this->load( "input-validator" );
        $prospectRepo = $this->load( "prospect-repository" );
        $memberRepo = $this->load( "member-repository" );
        $appointmentRepo = $this->load( "appointment-repository" );
        $accountRepo = $this->load( "account-repository" );
        $accountTypeRepo = $this->load( "account-type-repository" );

        $account_type_ids = [];

        // Get all account type ids
        $account_types = $accountTypeRepo->getAll();
        foreach ( $account_types as $account_type ) {
            $account_type_ids[] = $account_type->id;
        }

        // Get pending leads and leads on trial
        $leads = $prospectRepo->getAllByStatusAndBusinessID( "pending", $this->business->id );
        $trials = $prospectRepo->getAllByTypeAndBusinessID( "trial", $this->business->id );

        // Load members
        $members = $memberRepo->getAllByBusinessID( $this->business->id );

        // Load appointments
        $appointments = [];
        $appointmentsAll = $appointmentRepo->getAllByBusinessID( $this->business->id );
        foreach ( $appointmentsAll as $appointment ) {
            if ( $appointment->status == "pending" ) {
                $appointments[] = $appointment;
            }
        }

        // Process account type update
        if ( $input->exists() && $input->issetField( "account_type_update" ) && $inputValidator->validate(

                $input,

                [
                    "token" => [
                        "equals-hidden" => $this->session->getSession( "csrf-token" ),
                        "required" => true
                    ],
                    "account_type_id" => [
                        "name" => "Account Type ID",
                        "required" => true,
                        "in-array" => $account_type_ids
                    ]
                ],

                "account_type_update" /* error index */
            ) )
        {
            $accountRepo->updateAccountTypeIDByID( $this->account->id, $input->get( "account_type_id" ) );
            $this->view->redirect( "jjs-admin/business/" . $this->business->id . "/" );
        }

        // Process account type update
        if ( $input->exists() && $input->issetField( "add_credit" ) && $inputValidator->validate(

                $input,

                [
                    "token" => [
                        "equals-hidden" => $this->session->getSession( "csrf-token" ),
                        "required" => true
                    ],
                    "credit" => [
                        "name" => "Credit",
                        "required" => true,
                        "number" => true
                    ]
                ],

                "account_type_update" /* error index */
            ) )
        {
            $accountRepo->addAccountCreditByID( $this->account->id, $input->get( "credit" ) );
            $this->view->redirect( "jjs-admin/business/" . $this->business->id . "/" );
        }

        $this->view->assign( "leads", $leads );
        $this->view->assign( "appointments", $appointments );
        $this->view->assign( "trials", $trials );
        $this->view->assign( "members", $members );
        $this->view->assign( "account_types", $account_types );

        $this->view->assign( "csrf_token", $this->session->generateCSRFToken() );
        $this->view->setErrorMessages( $inputValidator->getErrors() );

        $this->view->setTemplate( "jjs-admin/business/home.tpl" );
        $this->view->render( "App/Views/JJSAdmin/Business.php" );
    }

}
