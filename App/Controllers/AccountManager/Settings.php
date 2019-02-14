<?php

namespace Controllers\AccountManager;

use Core\Controller;

class Settings extends Controller
{

    public function before()
    {
        // Loading services
        $userAuth = $this->load( "user-authenticator" );
        $accountRepo = $this->load( "account-repository" );
        $accountUserRepo = $this->load( "account-user-repository" );
        $accountTypeRepo = $this->load( "account-type-repository" );
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

        // Grab business details
        $this->business = $businessRepo->getByID( $this->user->getCurrentBusinessID() );

        // Track with facebook pixel
		$Config = $this->load( "config" );
		$facebookPixelBuilder = $this->load( "facebook-pixel-builder" );

		$facebookPixelBuilder->addPixelID( $Config::$configs[ "facebook" ][ "jjs_pixel_id" ] );
		$this->view->assign( "facebook_pixel", $facebookPixelBuilder->build() );

        // Set data for the view
        $this->view->assign( "account", $this->account );
        $this->view->assign( "account_type", $this->accountType );
        $this->view->assign( "user", $this->user );
        $this->view->assign( "business", $this->business );
    }

    public function indexAction()
    {
        $this->view->redirect( "account-manager/settings/user-management" );
    }

    public function addUserAction()
    {
        $input = $this->load( "input" );
        $inputValidator = $this->load( "input-validator" );
        $countryRepo = $this->load( "country-repository" );
        $phoneRepo = $this->load( "phone-repository" );
        $userRepo = $this->load( "user-repository" );
        $userRegistrar = $this->load( "user-registrar" );
        $accessControl = $this->load( "access-control" );

        if ( !$accessControl->hasAccess( [ "owner", "administrator", "manager" ], $this->user->role ) ) {
            $this->view->render403();
        }

        // Load user emails to veryify submitted email address is unique
        $user_emails = $userRepo->getAllEmails();

        $countries = $countryRepo->get( [ "*" ] );

        if ( $input->exists() && $inputValidator->validate(

                $input,

                [
                    "token" => [
                        "equals-hidden" => $this->session->getSession( "csrf-token" ),
                        "required" => true
                    ],
                    "add_user" => [
                        "required" => true
                    ],
                    "first_name" => [
                        "name" => "First Name",
                        "min" => 1,
                        "max" => 250,
                        "required" => true
                    ],
                    "last_name" => [
                        "name" => "Last Name",
                        "min" => 1,
                        "max" => 250,
                        "required" => true
                    ],
                    "email" => [
                        "name" => "Email",
                        "required" => true,
                        "email" => true,
                        "unique" => $user_emails
                    ],
                    "country_code" => [
                        "name" => "Country Code",
                        "required" => true,
                        "min" => 1
                    ],
                    "phone_number" => [
                        "name" => "Phone Number",
                        "required" => true,
                        "phone" => true
                    ],
                    "password" => [
                        "name" => "Password",
                        "required" => true,
                        "min" => 6,
                    ],
                    "confirm_password" => [
                        "name" => "Confirm Password",
                        "required" => true,
                        "equals" => $input->get( "password" )
                    ],
                    "role" => [
                        "name" => "Role",
                        "required" => true,
                        "in_array" => [ "administrator", "manager", "standard" ]
                    ],
                    "terms" => [
                        "name" => "Terms and Conditions",
                        "required" => true,
                        "equals-hidden" => $this->session->getSession( "csrf-token" )
                    ]
                ],
                "add_user"
            )
        ) {
            $phone = $phoneRepo->create( $input->get( "country_code" ), $input->get( "phone_number" ) );
            $userRegistrar->register(
                    $this->account->id,
                    $this->user->current_business_id,
                    $input->get( "first_name" ),
                    $input->get( "last_name" ),
                    $phone->id,
                    $input->get( "email" ),
                    $input->get( "role" ),
                    $input->get( "password" ),
                    true /* user terms and conditions */
                );

            $this->view->redirect( "account-manager/settings/user-management" );
        }

        // input values returned on failed form validation
        $inputs = [];

        if ( $input->issetField( "add_user" ) ) {
            $inputs[ "add_user" ][ "first_name" ] = $input->get( "first_name" );
            $inputs[ "add_user" ][ "last_name" ] = $input->get( "last_name" );
            $inputs[ "add_user" ][ "email" ] = $input->get( "email" );
            $inputs[ "add_user" ][ "phone_number" ] = $input->get( "phone_number" );
        }

        $this->view->assign( "inputs", $inputs );

        $this->view->assign( "countries", $countries );

        $this->view->assign( "csrf_token", $this->session->generateCSRFToken() );
        $this->view->setErrorMessages( $inputValidator->getErrors() );

        $this->view->setTemplate( "account-manager/settings/add-user.tpl" );
        $this->view->render( "App/Views/AccountManager/Settings.php" );
    }

    public function manageCredentialsAction()
    {
        $input = $this->load( "input" );
        $inputValidator = $this->load( "input-validator" );
        $userRepo = $this->load( "user-repository" );

        if ( $input->exists() && $inputValidator->validate(
                $input,
                [
                    "token" => [
                        "equals-hidden" => $this->session->getSession( "csrf-token" ),
                        "required" => true
                    ],
                    "update_password" => [
                        "required" => true
                    ],
                    "email" => [
                        "name" => "Email",
                        "required" => true,
                        "email" => true,
                        "equals" => $this->user->email
                    ],
                    "password" => [
                        "name" => "Password",
                        "required" => true,
                        "min" => 6,
                    ],
                    "confirm_password" => [
                        "name" => "Confirm Password",
                        "required" => true,
                        "equals" => $input->get( "password" )
                    ]
                ],
                "update_password"
            )
        ) {
            $userRepo->updatePasswordByID( $input->get( "password" ), $this->user->id );
            $this->view->redirect( "account-manager/settings/user-management" );
        }

        // Return input data on failed validation
        $inputs = [];

        if ( $input->issetField( "update_password" ) ) {
            $inputs[ "update_password" ][ "email" ] = $input->get( "email" );
        }

        $this->view->assign( "inputs", $inputs );

        $this->view->assign( "csrf_token", $this->session->generateCSRFToken() );
        $this->view->setErrorMessages( $inputValidator->getErrors() );

        $this->view->setTemplate( "account-manager/settings/manage-credentials.tpl" );
        $this->view->render( "App/Views/AccountManager/Settings.php" );
    }

    public function userManagementAction()
    {
        $userRepo = $this->load( "user-repository" );

        $users = $userRepo->getAllByAccountID( $this->account->id );

        $this->view->assign( "users", $users );
        $this->view->assign( "flash_messages", $this->session->getFlashMessages() );

        $this->view->setTemplate( "account-manager/settings/user-management.tpl" );
        $this->view->render( "App/Views/AccountManager/Settings.php" );
    }

}
