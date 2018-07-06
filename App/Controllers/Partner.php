<?php

namespace Controllers;

use \Core\Controller;

class Partner extends Controller
{
	public $geoInfo;

	public function before()
	{
		$ipinfo = $this->load( "ip-info" );
		$timezonedb = $this->load( "timezonedb" );
		$countryRepo = $this->load( "country-repository" );
		$currencyRepo = $this->load( "currency-repository" );

		// Get geo info of user by ip using the IPInfo API
		$this->geoInfo = $ipinfo->getGeoByIP();

		$iso = "US";

		if ( $this->geoInfo !== false ) {
			$iso = $this->geoInfo->country;
		}

		// Get country details according to iso code returned by ip info. Default to US
		$this->country = $countryRepo->getByISO( $iso );

		// Get currency details by name. Default USD
		$this->currency = $currencyRepo->getByCountry( $this->country->name );
		if ( $this->currency->code == null ) {
			$this->currency = $currecnyRepo->getByCountry( "United States" );
		}

		// Get timezone details. Default to American/Chicago
		$timezoneData = $timezonedb->getTimezoneByIP( $ipinfo->getIP() );
		$this->timezone = "American/Chicago";

		if ( $timezoneData !== false && $timezoneData->status == "OK" ) {
			$this->timezone = $timezoneData->zoneName;
		}

	}

	public function indexAction()
	{
		$this->view->setTemplate( "partner/partner.tpl" );
		$this->view->render( "App/Views/Partner.php" );
	}

	public function signUpAction()
	{
		$input = $this->load( "input" );
		$inputValidator = $this->load( "input-validator" );
		$countryRepo = $this->load( "country-repository" );
		$accountRepo = $this->load( "account-repository" );
		$accountRegistrar = $this->load( "account-registrar" );
		$businessRegistrar = $this->load( "business-registrar" );
		$businessRepo = $this->load( "business-repository" );
		$userRepo = $this->load( "user-repository" );
		$userRegistrar = $this->load( "user-registrar" );
		$phoneRepo = $this->load( "phone-repository" );
		$groupRepo = $this->load( "group-repository" );

		$salesAgentMailer = $this->load( "sales-agent-mailer" );

		// Get array of all emails to check if submitted email is unique
		$emails = $userRepo->getAllEmails();

		// Get all countries for phone code
		$countries = $countryRepo->getAll();

		// If gym name was submitted from previous page, insert that value into gym_name input
		$gym_name = null;
		if ( $input->exists() && $input->issetField( "gym_name" ) ) {
			$gym_name = $input->get( "gym_name" );
		}

		if ( $input->exists() && $input->issetField( "create_account" ) && $inputValidator->validate(

				$input,

				[
					"token" => [
						"equals-hidden" => $this->session->getSession( "csrf-token" ),
						"required" => true
					],
					"create_account" => [
						"required" => true
					],
					"gym_name" => [
						"name" => "Gym Name",
						"required" => true,
						"min" => 1,
						"max" => 100
					],
					"first_name" => [
						"name" => "First Name",
						"required" => true,
						"min" => 1,
						"max" => 150
					],
					"email" => [
						"name" => "Email",
						"required" => true,
						"email" => true,
						"unique" => $emails
					],
					"country_code" => [
						"name" => "Country Code",
						"required" => true,
					],
					"phone_number" => [
						"name" => "Phone Number",
						"required" => true,
						"phone" => true
					],
					"password" => [
						"name" => "Password",
						"required" => true
					],
					"confirm_password" => [
						"name" => "Confirm Password",
						"required" => true,
						"equals" => $input->get( "password" )
					],
					"terms_conditions_agreement" =>  [
						"name" => "Terms and Conditions",
						"required" => true,
						"equals" => "true"
					]
				],

				"create_account" /* error index */
			) )
		{
			$gym_name = $input->get( "gym_name" );
			$first_name = $input->get( "first_name" );
			$email = $input->get( "email" );
			$country_code = $input->get( "country_code" );
			$phone_number = $input->get( "phone_number" );
			$password = $input->get( "password" );
			$terms_conditions_agreement = $input->get( "terms_conditions_agreement" );

			$account_type_id = 1; /* Free account */
			$accountRegistrar->register( $account_type_id, $this->country->iso, $this->currency->code, $this->timezone );
			$account = $accountRegistrar->getAccount();

			$businessRegistrar->register( $account->id, $gym_name, $first_name, $input->get( "country_code" ), $input->get( "phone_number" ), $email, $this->country->iso, $this->timezone );
			$business = $businessRegistrar->getBusiness();

			// Create phone resource for user
			$phone = $phoneRepo->create( $input->get( "country_code" ), $input->get( "phone_number" ) );

			// Register user
			$userRegistrar->register( $account->id, $business->id, $first_name, "", $phone->id, $email, "administrator", $password, $terms_conditions_agreement );
			$user = $userRegistrar->getUser();

			// Add user to user notification list for business
			$businessRepo->updateUserNotificationRecipientIDsByID( $business->id, [ $user->id ] );

			// Set primary user id for new account
			$accountRepo->updatePrimaryUserIDByID( $user->id, $account->id );

			// Notify JJS Agent by email of new sign up
			$salesAgentMailer->sendPartnerSignUpAlert( $first_name, $gym_name, $email, $input->get( "country_code" ) . $input->get( "phone_number" ) );

			$userAuth = $this->load( "user-authenticator" );
			$userAuth->login( $email, $password );

			$this->view->redirect( "account-manager/business/" );

		}

		// Set variables to populate inputs after form submission failure and assign to view
        $inputs = [];
        // add_note
        if ( $input->issetField( "create_account" ) ) {
            $inputs[ "create_account" ][ "gym_name" ] = $input->get( "gym_name" );
            $inputs[ "create_account" ][ "first_name" ] = $input->get( "first_name" );
            $inputs[ "create_account" ][ "email" ] = $input->get( "email" );
			$inputs[ "create_account" ][ "country_code" ] = $input->get( "country_code" );
            $inputs[ "create_account" ][ "phone_number" ] = $input->get( "phone_number" );
        }

        // Input values submitted from form
        $this->view->assign( "inputs", $inputs );

		$this->view->assign( "countries", $countries );
		$this->view->assign( "country", $this->country );

		$this->view->assign( "gym_name", $gym_name );

		$this->view->assign( "csrf_token", $this->session->generateCSRFToken() );
        $this->view->setErrorMessages( $inputValidator->getErrors() );

		$this->view->setTemplate( "partner/sign-up.tpl" );
		$this->view->render( "App/Views/Partner.php" );
	}

}
