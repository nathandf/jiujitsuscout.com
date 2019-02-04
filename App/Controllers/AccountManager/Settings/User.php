<?php

namespace Controllers\AccountManager\Settings;

use Core\Controller;

class User extends Controller
{

    public function before()
    {
        $this->requireParam( "id" );
        // Loading services
        $userAuth = $this->load( "user-authenticator" );
        $accountRepo = $this->load( "account-repository" );
        $accountTypeRepo = $this->load( "account-type-repository" );
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

        // Load account type details
		$this->accountType = $accountTypeRepo->get( [ "*" ], [ "id" => $this->account->account_type_id ], "single" );

        // Get all users
        $users = $userRepo->getAllByAccountID( $this->account->id );
        $user_ids = [];

        foreach ( $users as $user ) {
            $user_ids[] = $user->id;
        }

        // Only allow access to current logged in user
        if ( !in_array( $this->params[ "id" ], $user_ids ) ) {
            $this->view->redirect( "account-manager/settings/user-management" );
        }

        // Grab business details
        $this->business = $businessRepo->getByID( $this->user->getCurrentBusinessID() );
        // Set data for the view
        $this->view->assign( "account", $this->account );
        $this->view->assign( "account_type", $this->accountType );
        $this->view->assign( "user", $this->user );
        $this->view->assign( "business", $this->business );
    }

    public function indexAction()
    {
        $this->view->redirect( "account-manager/settings/user/" . $this->params[ "id" ] . "/edit" );
    }

    public function editAction()
    {
        $input = $this->load( "input" );
        $inputValidator = $this->load( "input-validator" );
        $phoneRepo = $this->load( "phone-repository" );
        $userRepo = $this->load( "user-repository" );
        $countryRepo = $this->load( "country-repository" );
        $factory = $this->load( "entity-factory" );
        $accessControl = $this->load( "access-control" );

        if ( !$accessControl->hasAccess( [ "administrator" ], $this->user->role ) ) {
            $this->view->render403();
        }

        $countries = $countryRepo->get( [ "*" ] );

        // Load in the user refenced by the id param
        $userToEdit = $userRepo->getByID( $this->params[ "id" ] );

        // Get phone resource associated with this user
        $phone = $phoneRepo->getByID( $userToEdit->phone_id );

        // Get array of user emails to verify submitted email is unique
        $user_emails = $userRepo->getAllEmails();
        // Remove userToEdits email from the array so that the form can be submitted with no error
        $email_index = array_search( $userToEdit->email, $user_emails );
        unset( $user_emails[ $email_index ] );

        if ( $input->exists() && $input->issetField( "edit_user" ) && $inputValidator->validate(

                $input,

                [
                    "token" => [
                        "equals-hidden" => $this->session->getSession( "csrf-token" ),
                        "required" => true
                    ],
                    "edit_user" => [
                        "required" => true
                    ],
                    "first_name" => [
                        "name" => "First Name",
                        "required" => true
                    ],
                    "last_name" => [
                        "name" => "Last Name",
                        "required" => true,
                    ],
                    "email" => [
                        "name" => "Email",
                        "required" => true,
                        "email" => true,
                        "unique" => $user_emails
                    ],
                    "country_code" => [
                        "name" => "Country Code",
                        "min" => 1,
                        "max" => 5
                    ],
                    "phone_number" => [
                        "name" => "Phone Number",
                        "phone" => true
                    ],
                    "role" => [
                        "name" => "Role"
                    ]
                ],

                "edit_user" /* error index */
            ) )
        {
            $user = $factory->build( "User" );
            $user->first_name = $input->get( "first_name" );
            $user->last_name = $input->get( "last_name" );

            $user->email = $input->get( "email" );

            $phone->country_code = $input->get( "country_code" );
            $phone->national_number = $input->get( "phone_number" );

            $phoneRepo->updateByID( $phone, $userToEdit->phone_id );

            // This is a mess. TODO fix
            $userRepo->updateUserByID( $userToEdit->id, $user );

            // Disallow changing own permissions
            if ( $this->user->id != $this->params[ "id" ] ) {
                $userRepo->updateRoleByID( $this->params[ "id" ], $input->get( "role" ) );
            }

            $this->view->redirect( "account-manager/settings/user/" . $userToEdit->id . "/edit" );
        }

        $this->view->assign( "user_to_edit", $userToEdit );
        $this->view->assign( "phone", $phone );
        $this->view->assign( "roles", $accessControl->getRoles() );
        $this->view->assign( "countries", $countries );

        $this->view->assign( "csrf_token", $this->session->generateCSRFToken() );
        $this->view->setErrorMessages( $inputValidator->getErrors() );

        $this->view->setTemplate( "account-manager/settings/user/edit.tpl" );
        $this->view->render( "App/Views/AccountManager/Settings/User.php" );
    }

}
