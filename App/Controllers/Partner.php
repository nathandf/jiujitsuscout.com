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
		$Config = $this->load( "config" );
        $facebookPixelBuilder = $this->load( "facebook-pixel-builder" );
        $facebookPixelBuilder->addPixelID( $Config::$configs[ "facebook" ][ "jjs_pixel_id" ] );

		$this->view->assign( "facebook_pixel", $facebookPixelBuilder->build() );

		// Get geo info of user by ip using the IPInfo API
		$this->geoInfo = $ipinfo->getGeoByIP();

		$iso = "US";

		if ( $this->geoInfo !== false ) {
			$iso = $this->geoInfo->country;
		}

		// Get country details according to iso code returned by ip info. Default to US
		$this->country = $countryRepo->get( [ "*" ], [ "iso" => $iso ], "single" );

		// Get currency details by name. Default USD
		$this->currency = $currencyRepo->getByCountry( $this->country->name );
		if ( $this->currency->code == null ) {
			$this->currency = $currecnyRepo->getByCountry( "United States" );
		}

		// Get timezone details. Default to America/Chicago
		$timezoneData = $timezonedb->getTimezoneByIP( $ipinfo->getIP() );
		$this->timezone = "America/Chicago";

		if ( $timezoneData !== false && $timezoneData->status == "OK" ) {
			$this->timezone = $timezoneData->zoneName;
		}

	}

	public function indexAction()
	{
		$input = $this->load( "input" );
		$inputValidator = $this->load( "input-validator" );
		$salesAgentMailer = $this->load( "sales-agent-mailer" );

		if ( $input->exists() && $input->issetField( "marketing_consultation" ) && $inputValidator->validate(
				$input,
				[
					"token" => [
						"equals-hidden" => $this->session->getSession( "csrf-token" ),
						"required" => true
					],
					"name" => [
						"name" => "Name",
						"required" => true
					],
					"email" => [
						"name" => "Email",
						"required" => true
					],
					"phone" => [
						"name" => "Phone",
						"required" => true
					],
					"budget" => [],
					"students" => [],
					"message" => []
				],
				"marketing_consultation"
			)
		) {
			$salesAgentMailer->sendConsultationAlert(
				$input->get( "name" ),
				$input->get( "email" ),
				$input->get( "phone" ),
				$input->get( "budget" ),
				$input->get( "students" ),
				$input->get( "message" )
			);
			$this->view->redirect( "partner/thank-you" );
		}

		$this->view->assign( "csrf_token", $this->session->generateCSRFToken() );
        $this->view->setErrorMessages( $inputValidator->getErrors() );

		$this->view->setTemplate( "partner/partner.tpl" );
		$this->view->render( "App/Views/Partner.php" );
	}

	public function thankYouAction()
	{
		$Config = $this->load( "config" );
		$facebookPixelBuilder = $this->load( "facebook-pixel-builder" );

        $facebookPixelBuilder->addPixelID( $Config::$configs[ "facebook" ][ "jjs_pixel_id" ] );
		$facebookPixelBuilder->addEvent( "Lead" );

		$this->view->assign( "facebook_pixel", $facebookPixelBuilder->build() );

		$this->view->setTemplate( "partner/thank-you.tpl" );
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
		$addressRepo = $this->load( "address-repository" );
		$accountUserRepo = $this->load( "account-user-repository" );
		$businessUserRepo = $this->load( "business-user-repository" );
		$userMailer = $this->load( "user-mailer" );
		$salesAgentMailer = $this->load( "sales-agent-mailer" );

		// Get array of all emails to check if submitted email is unique
		$emails = $userRepo->getAllEmails();

		// Get all countries for phone code
		$countries = $countryRepo->get( [ "*" ] );

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
					"name" => [
						"name" => "Name",
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
					"terms_conditions_agreement" =>  [
						"name" => "Terms and Conditions",
						"required" => true,
						"equals" => "true"
					]
				],

				"create_account" /* error index */
			) )
		{
			$account = $accountRepo->insert([
				"account_type_id" => 1, /* Free account */
				"timezone" => $this->timezone,
				"currency" => $this->currency->code,
				"country" => $this->country->iso
			]);

			$phone = $phoneRepo->insert([
				"country_code" => $input->get( "country_code" ),
				"national_number" => $input->get( "phone_number" )
			]);

			$address = $addressRepo->insert([
				"country_id" => $this->country->id
			]);

			$business = $businessRepo->insert([
				"account_id" => $account->id,
				"business_name" => $input->get( "gym_name" ),
				"email" => $input->get( "email" ),
				"contact_name" => $input->get( "name" ),
				"phone_id" => $phone->id,
				"address_id" => $address->id,
				"timezone" => $this->timezone,
                "country" => $this->country->iso
			]);

			// Register user
			$user = $userRepo->insert([
				"account_id" => $account->id,
				"first_name" => $input->get( "name" ),
				"phone_id" => $phone->id,
				"current_business_id" => $business->id,
				"email" => $input->get( "email" ),
				"role" => "owner",
				"password" => password_hash( $input->get( "password" ), PASSWORD_BCRYPT ),
				"terms_conditions_agreement" => $input->get( "terms_conditions_agreement" )
			]);

			$accountUser = $accountUserRepo->insert([
				"account_id" => $account->id,
				"user_id" => $user->id
			]);

			$businessUser = $businessUserRepo->insert([
				"business_id" => $business->id,
				"user_id" => $user->id
			]);

			$userMailer->sendWelcomeEmail( $user->first_name, $user->email );

			// Add user to user notification list for business
			$businessRepo->updateUserNotificationRecipientIDsByID( $business->id, [ $user->id ] );

			// Set primary user id for new account
			$accountRepo->update( [ "primary_user_id" => $user->id ], [ "id" => $account->id ] );

			// Notify JJS Agent by email of new sign up
			$salesAgentMailer->sendPartnerSignUpAlert( $user->first_name, $business->business_name, $business->email, $phone->getNicePhoneNumber() );

			$userAuth = $this->load( "user-authenticator" );
			$userAuth->login( $user->email, $input->get( "password" ) );

			$this->view->redirect( "account-manager/business/profile/" );
		}

		// Set variables to populate inputs after form submission failure and assign to view
        $inputs = [];
        // add_note
        if ( $input->issetField( "create_account" ) ) {
            $inputs[ "create_account" ][ "gym_name" ] = $input->get( "gym_name" );
            $inputs[ "create_account" ][ "name" ] = $input->get( "name" );
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
