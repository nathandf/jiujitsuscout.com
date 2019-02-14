<?php

namespace Controllers;

use Core\Controller;

class AccountManager extends Controller
{
	private $businesses = [];
	private $business;
	private $account;
	private $accountType;
	private $user;

	public function before()
	{
		// Loading services
		$userAuth = $this->load( "user-authenticator" );
		$accountRepo = $this->load( "account-repository" );
		$accountTypeRepo = $this->load( "account-type-repository" );
		$accountUserRepo = $this->load( "account-user-repository" );
		$businessRepo = $this->load( "business-repository" );
		$userRepo = $this->load( "user-repository" );
		$imageRepo = $this->load( "image-repository" );

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

		// Load current selected business data
		$this->business = $businessRepo->get( [ "*" ], [ "id" => $this->user->getCurrentBusinessID() ], "single" );

		// Load data from all businesses owned by this account and store in array
		$this->businesses = $businessRepo->get( [ "*" ], [ "account_id" => $this->user->account_id ] );

		// Load the logo image for each business
		foreach ( $this->businesses as $_business ) {
			if ( !is_null( $_business->logo_image_id ) ) {
				$_business->logo = $imageRepo->get( [ "*" ], [ "id" => $_business->logo_image_id ], "single" );
			}
		}

		$total_businesses = count( $this->businesses );

		// Load data from all users attatched to this account and store in array
		$this->users = $userRepo->get( [ "*" ], [ "account_id" => $this->user->account_id ] );
		$total_users = count( $this->users );

		// Track with facebook pixel
		$Config = $this->load( "config" );
		$facebookPixelBuilder = $this->load( "facebook-pixel-builder" );

		$facebookPixelBuilder->addPixelID( $Config::$configs[ "facebook" ][ "jjs_pixel_id" ] );
		$this->view->assign( "facebook_pixel", $facebookPixelBuilder->build() );

		// Set data for the view
		$this->view->assign( "total_users", $total_users );
		$this->view->assign( "total_businesses", $total_businesses );
		$this->view->assign( "account", $this->account );
		$this->view->assign( "account_type", $this->accountType );
		$this->view->assign( "user", $this->user );
		$this->view->assign( "business", $this->business );
		$this->view->assign( "businesses", $this->businesses );
	}

	public function signIn()
	{
		$input = $this->load( "input" );
		$inputValidator = $this->load( "input-validator" );

		$userAuth = $this->load( "user-authenticator" );
		// If user logged in, send to account manager dashboard
		if ( $userAuth->userValidate() ) {
			$this->user = $userAuth->getUser();
			if ( is_null( $this->user->getCurrentBusinessID() ) ) {
				$this->view->redirect( "account-manager/choose-business" );
			}
			$this->view->redirect( "account-manager/" );
		}

		// Track with facebook pixel
		$Config = $this->load( "config" );
		$facebookPixelBuilder = $this->load( "facebook-pixel-builder" );

		$facebookPixelBuilder->addPixelID( $Config::$configs[ "facebook" ][ "jjs_pixel_id" ] );
		$this->view->assign( "facebook_pixel", $facebookPixelBuilder->build() );

		// processing login form validation
		if ( $input->exists() && $inputValidator->validate(

				$input,

		        [
					"token" => [
						"equals-hidden" => $this->session->getSession( "csrf-token" ),
						"required" => true
					],
						"sign_in" => [
						"required" => true
					],
						"email" => [
						"name" => "Email",
						"required" => true,
						"email" => true
					],
						"password" => [
						"name" => "Password",
						"required" => true,
					]
		        ],

		        "sign_in" /* error index */
        	) )
	    {
			if ( $userAuth->logIn( $input->get( "email" ), $input->get( "password" ) ) ) {
				$this->view->redirect( "account-manager/choose-business" );
			} else {
				$inputValidator->addError( "sign_in", "Email and/or password are incorrect." );
			}
		}

	    // Set variables to populate inputs after form submission failure and assign to view
	    $inputs = [];

	    // sidebar_promo
	    if ( $input->issetField( "sign_in" ) ) {
	        $inputs[ "sign_in" ][ "email" ] = $input->get( "email" );
	        $inputs[ "sign_in" ][ "password" ] = $input->get( "password" );
	    }

	    // Input values submitted from form
	    $this->view->assign( "inputs", $inputs );

	    $this->view->assign( "csrf_token", $this->session->generateCSRFToken() );
	    $this->view->setErrorMessages( $inputValidator->getErrors() );

		$this->view->setTemplate( "account-manager/partner-sign-in.tpl" );
		$this->view->render( "App/Views/AccountManager.php" );
	}

	public function chooseBusiness()
	{
		// Load Services
		$userRepo = $this->load( "user-repository" );
		$businessRepo = $this->load( "business-repository" );
		$accountUserRepo = $this->load( "account-user-repository" );
		$imageRepo = $this->load( "image-repository" );
		// Require user login. If not logged in, send back to sign in
		$userAuth = $this->load( "user-authenticator" );
		if ( !$userAuth->userValidate() ) {
			$this->view->redirect( "account-manager/sign-in" );
		}
		$this->user = $userAuth->getUser();
		$accountUser = $accountUserRepo->get( [ "*" ], [ "user_id" => $this->user->id ], "single" );
		
		// Load account user reference
		$businesses = $businessRepo->getAllByAccountID( $accountUser->account_id );
		$total_businesses = count( $businesses );

		foreach ( $businesses as $_business ) {
			$_business->logo = $imageRepo->get( [ "*" ], [ "id" => $_business->logo_image_id ], "single" );
		}

		// If only one business, set the current bussiness id and redirect to dashboard
		if ( $total_businesses == 1 ) {
			$this->user->setCurrentBusinessID( $businesses[ 0 ]->id );
			$userRepo->updateCurrentBusinessID( $this->user );
			$this->view->redirect( "account-manager/business/" );
		}

		// Track with facebook pixel
		$Config = $this->load( "config" );
		$facebookPixelBuilder = $this->load( "facebook-pixel-builder" );

		$facebookPixelBuilder->addPixelID( $Config::$configs[ "facebook" ][ "jjs_pixel_id" ] );
		$this->view->assign( "facebook_pixel", $facebookPixelBuilder->build() );

		// Load input helpers
		$input = $this->load( "input" );
		$inputValidator = $this->load( "input-validator" );
		// If form is submitted, set save the current business id and redirect to dashboard
		if ( $input->exists() && $inputValidator->validate( $input,
				[
					"token" => [
						"equals-hidden" => $this->session->getSession( "csrf-token" ),
						"required" => true
					],
					"business_id" => [
						"name" => "Business ID",
						"required" => true,
						"min" => 1
					],
				],

				"choose_business" /* error index */
			) )
		{
			$this->user->setCurrentBusinessID( $input->get( "business_id" ) );
			$userRepo->updateCurrentBusinessID( $this->user );
			$this->view->redirect( "account-manager/business/" );
		}

	    $this->view->assign( "csrf_token", $this->session->generateCSRFToken() );
	    $this->view->setErrorMessages( $inputValidator->getErrors() );

		$this->view->assign( "businesses", $businesses );
		$this->view->assign( "user", $this->user );
		$this->view->setTemplate( "account-manager/choose-business.tpl" );
		$this->view->render( "App/Views/AccountManager.php" );
	}

	public function indexAction()
	{
		// Load input helpers
		$input = $this->load( "input" );
		$inputValidator = $this->load( "input-validator" );
		$userRepo = $this->load( "user-repository" );
		$businessRepo = $this->load( "business-repository" );

		$business_ids = $businessRepo->get( [ "id" ], [ "account_id" => $this->account->id ], "raw" );

		// If form is submitted, set save the current business id and redirect to dashboard
		if ( $input->exists( "get" ) && $inputValidator->validate(
				$input,
				[
					"token" => [
						"equals-hidden" => $this->session->getSession( "csrf-token" ),
						"required" => true
					],
					"business_id" => [
						"name" => "Business ID",
						"required" => true,
						"in_array" => $business_ids
					],
				],
				"choose_business" /* error index */
			) )
		{
			$this->user->setCurrentBusinessID( $input->get( "business_id" ) );
			$userRepo->updateCurrentBusinessID( $this->user );
			$this->view->redirect( "account-manager/business/" );
		}

	    $this->view->assign( "csrf_token", $this->session->generateCSRFToken() );
	    $this->view->setErrorMessages( $inputValidator->getErrors() );

		$this->view->setTemplate( "account-manager/home.tpl" );
		$this->view->render( "App/Views/AccountManager.php" );
	}

	public function businessesAction()
	{
		$input = $this->load( "input" );
		$inputValidator = $this->load( "input-validator" );
		$userRepo = $this->load( "user-repository" );
		if ( $input->exists() && $inputValidator->validate( $input,
				[
					"token" => [
						"equals-hidden" => $this->session->getSession( "csrf-token" ),
						"required" => true
					],
					"business_id" => [
						"name" => "Business ID",
						"required" => true,
					]
				],

				"choose_business" /* error index */
			) )
		{
			$this->user->setCurrentBusinessID( $input->get( "business_id" ) );
			$userRepo->updateCurrentBusinessID( $this->user );
			$this->view->redirect( "account-manager/business/" );
		}

	    $this->view->assign( "csrf_token", $this->session->generateCSRFToken() );
	    $this->view->setErrorMessages( $inputValidator->getErrors() );

		$this->view->setTemplate( "account-manager/choose-business.tpl" );
		$this->view->render( "App/Views/AccountManager.php" );
	}

	public function addBusinessAction()
	{
		$input = $this->load( "input" );
		$inputValidator = $this->load( "input-validator" );
		$userRepo = $this->load( "user-repository" );
		$businessRepo = $this->load( "business-repository" );
		$businessRegistrar = $this->load( "business-registrar" );
		$groupRepo = $this->load( "group-repository" );
		$countryRepo = $this->load( "country-repository" );
		$salesAgentMailer = $this->load( "sales-agent-mailer" );
		$phoneRepo = $this->load( "phone-repository" );
		$geocoder = $this->load( "geocoder" );
		$accessControl = $this->load( "access-control" );
		$addressRepo = $this->load( "address-repository" );

		// Restrict access to admins
		if ( !$accessControl->hasAccess( [ "administrator" ], $this->user->role ) ) {
			$this->view->render403();
		}

        $countries = $countryRepo->get( [ "*" ] );
		$phone = $phoneRepo->getByID( $this->user->phone_id );

		if ( $input->exists() && $inputValidator->validate( $input,
				[
					"token" => [
						"equals-hidden" => $this->session->getSession( "csrf-token" ),
						"required" => true
					],
					"gym_name" => [
						"name" => "Gym Name",
						"required" => true,
						"min" => 1,
						"max" => 100
					],
					"email" => [
						"name" => "Email",
						"required" => true,
						"email" => true
					],
					"country_code" => [
						"name" => "Country Code",
						"required" => true,
						"phone" => true
					],
					"phone" => [
						"name" => "Phone Number",
						"required" => true,
						"phone" => true
					],
					"address_1" => [
                        "name" => "Address 1",
						"required" => true,
                        "max" => 250
                    ],
                    "address_2" => [
                        "name" => "Address 2",
                        "max" => 250
                    ],
                    "city" => [
                        "name" => "City",
						"required" => true,
                        "max" => 500
                    ],
                    "region" => [
                        "name" => "Region",
						"required" => true,
                        "max" => 500
                    ],
                    "postal_code" => [
                        "name" => "Postal Code",
						"required" => true,
                        "max" => 50
                    ],
					"country_id" => [
						"name" => "Country",
						"required" => true
					]
				],

				"add_business" /* error index */
			)
		) {
			$phone = $phoneRepo->insert([
				"country_code" => $input->get( "country_code" ),
				"national_number" => $input->get( "phone" )
			]);

			$address_2 = null;
			if ( $input->get( "address_2" ) != "" ) {
				$address_2 = $input->get( "address_2" );
			}

			$address = $addressRepo->insert([
				"address_1" => $input->get( "address_1" ),
                "address_2" => $address_2,
                "city" => $input->get( "city" ),
                "region" => $input->get( "region" ),
                "postal_code" => $input->get( "postal_code" ),
                "country_id" => $input->get( "country_id" )
			]);

			$country = $countryRepo->get( [ "*" ], [ "id" => $input->get( "country_id" ) ], "single");

			$business = $businessRepo->insert([
				"account_id" => $this->account->id,
				"business_name" => $input->get( "gym_name" ),
				"email" => $input->get( "email" ),
				"contact_name" => $this->user->first_name,
				"phone_id" => $phone->id,
				"address_id" => $address->id,
				"timezone" => $this->account->timezone,
				"address_1" => $input->get( "address_1" ),
                "address_2" => $input->get( "address_2" ),
                "city" => $input->get( "city" ),
                "region" => $input->get( "region" ),
                "postal_code" => $input->get( "postal_code" ),
                "country" => $country->iso
			]);

			// Get latlon of new address
            $full_address = $address->address_1 . " " . $address->address_2 . ", " . $address->region . " " . $address->postal_code . ", " . $country->iso;
            $geoInfo = $geocoder->getGeoInfoByAddress( $full_address );

            // Save new latitude and longitude
            $businessRepo->update(
				[
					"latitude" => $geoInfo->results[ 0 ]->geometry->location->lat,
					"longitude" => $geoInfo->results[ 0 ]->geometry->location->lng
				],
				[ "id" => $this->business->id ]
			);

			// Update current business id to new business
			$userRepo->update(
				[ "current_business_id" => $business->id ],
				[ "id" => $this->user->id ]
			);

			// Notify JJS Agent by email of new sign up
			$salesAgentMailer->sendAddBusinessAlert( $this->user->first_name, $business->business_name, $business->email, $phone->getNicePhoneNumber() );

			$this->view->redirect( "account-manager/business/" );
		}

		// Set variables to populate inputs after form submission failure and assign to view
		$inputs = [];

		// sidebar_promo
		if ( $input->issetField( "add_business" ) ) {
		   $inputs[ "add_business" ][ "gym_name" ] = $input->get( "gym_name" );
		   $inputs[ "add_business" ][ "email" ] = $input->get( "email" );
		   $inputs[ "add_business" ][ "phone" ] = $input->get( "phone" );
		   $inputs[ "add_business" ][ "country_code" ] = $input->get( "country_code" );
		   $inputs[ "add_business" ][ "address_1" ] = $input->get( "address_1" );
		   $inputs[ "add_business" ][ "address_2" ] = $input->get( "address_2" );
		   $inputs[ "add_business" ][ "city" ] = $input->get( "city" );
		   $inputs[ "add_business" ][ "region" ] = $input->get( "region" );
		   $inputs[ "add_business" ][ "country_id" ] = $input->get( "country_id" );
		   $inputs[ "add_business" ][ "postal_code" ] = $input->get( "postal_code" );
		}

		// Input values submitted from form
		$this->view->assign( "inputs", $inputs );

		$this->view->assign( "countries", $countries );
		$this->view->assign( "phone", $phone );

		$this->view->assign( "csrf_token", $this->session->generateCSRFToken() );
		$this->view->setErrorMessages( $inputValidator->getErrors() );

		$this->view->setTemplate( "account-manager/add-business.tpl" );
		$this->view->render( "App/Views/AccountManager.php" );
	}

	public function forgotPassword()
	{
		$input = $this->load( "input" );
		$inputValidator = $this->load( "input-validator" );
		$userRepo = $this->load( "user-repository" );
		$mailer = $this->load( "mailer" );
		$nonceTokenRepo = $this->load( "nonce-token-repository" );
		$passwordResetRepo = $this->load( "password-reset-repository" );

		$userEmails = $userRepo->getAllEmails();

		// Track with facebook pixel
		$Config = $this->load( "config" );
		$facebookPixelBuilder = $this->load( "facebook-pixel-builder" );

		$facebookPixelBuilder->addPixelID( $Config::$configs[ "facebook" ][ "jjs_pixel_id" ] );
		$this->view->assign( "facebook_pixel", $facebookPixelBuilder->build() );

		if ( $input->exists() && $inputValidator->validate(

				$input,

				[
					"token" => [
						"equals-hidden" => $this->session->getSession( "csrf-token" ),
						"required" => true
					],
					"email" => [
						"required" => true,
						"email" => true
					]
				],

				"forgot_password" /* forgot password */
			) )
		{
			if ( in_array( $input->get( "email" ), $userEmails ) ) {

				// Generate a nonce token
				$nonceToken = $nonceTokenRepo->create();

				// Save password reset
				$passwordResetRepo->create( $input->get( "email" ), $nonceToken->id );

				// Set email details
				$mailer->setRecipientName( "JiuJitsuScout User" );
				$mailer->setRecipientEmailAddress( $input->get( "email" ) );
				$mailer->setSenderName( "JiuJitsuScout" );
				$mailer->setSenderEmailAddress( "security@jiujitsuscout.com" );
				$mailer->setContentType( "text/html" );
				$mailer->setEmailSubject( "Password Reset Request" );
				$mailer->setEmailBody( "
					We have recieved your request to reset your password.
					<br><br>
					Click the link below to reset your password.
					<br>
					<a href='https://jiujitsuscout.com/jjs-admin/password-reset-validation?reset_token={$nonceToken->value}'>https://www.jiujitsuscout.com/account-manager/password-reset-validation?reset_token={$nonceToken->value}</a>
					<br><br>
					If you did not send a password reset request, ignore this message.
				" );
				$mailer->mail();

				$this->view->redirect( "account-manager/forgot-password" );
			}
		}

		$this->view->assign( "csrf_token", $this->session->generateCSRFToken() );
		$this->view->setErrorMessages( $inputValidator->getErrors() );

		$this->view->setTemplate( "account-manager/forgot-password.tpl" );
		$this->view->render( "App/Views/AccountManager.php" );
	}

	public function passwordResetValidation()
	{
		$input = $this->load( "input" );
		$inputValidator = $this->load( "input-validator" );
		$nonceTokenRepo = $this->load( "nonce-token-repository" );
		$passwordResetRepo = $this->load( "password-reset-repository" );
		$userRepo = $this->load( "user-repository" );
		$userAuthenticator = $this->load( "user-authenticator" );

		// Track with facebook pixel
		$Config = $this->load( "config" );
		$facebookPixelBuilder = $this->load( "facebook-pixel-builder" );

		$facebookPixelBuilder->addPixelID( $Config::$configs[ "facebook" ][ "jjs_pixel_id" ] );
		$this->view->assign( "facebook_pixel", $facebookPixelBuilder->build() );

		if ( $input->exists( "get" ) && $inputValidator->validate(

				$input,

				[
					"reset_token" => [
						"required" => true,
					]
				],

				"password_reset_validation" /* error index */
			) )
		{
			$nonceToken = $nonceTokenRepo->getByValue( $input->get( "reset_token" ) );
			$passwordReset = $passwordResetRepo->getByNonceTokenID( $nonceToken->id );

			// Verify that a valid password reset object was returned from database and token has not expired
			if ( is_null( $passwordReset->id ) || $nonceToken->expiration <= time() ) {
				$this->view->redirect( "account-manager/invalid-token" );
			}

			// Get user by email
			$user = $userRepo->getByEmail( $passwordReset->email );

			// Assign user data to view
			$this->view->assign( "user", $user );

			// Assign nonce token to view
			$this->view->assign( "reset_token", $nonceToken->value );

			// Validate that the form was reset password form was submitted and input are correct
			if ( $input->issetField( "reset_password" ) && $inputValidator->validate(

					$input,

					[
						"token" => [
							"equals-hidden" => $this->session->getSession( "csrf-token" ),
							"required" => true,
						],
						"reset_token" => [
							"required" => true,
							"equals" => $nonceToken->value
						],
						"email" => [
							"name" => "Email",
							"required" => true,
							"email" => true,
							"equals" => $user->email
						],
						"password" => [
							"name" => "Password",
							"required" => true,
							"min" => 6
						],
						"confirm_password" => [
							"name" => "Password Confirmation",
							"required" => true,
							"equals" => $input->get( "password" )
						]

					],

					"reset_password" /* error index */
				) )
			{
				$userRepo->updatePasswordByID( $input->get( "password" ), $user->id );
				$this->view->redirect( "account-manager/sign-in" );
			}
		}

		$this->view->assign( "csrf_token", $this->session->generateCSRFToken() );
		$this->view->setErrorMessages( $inputValidator->getErrors() );

		$this->view->setTemplate( "account-manager/reset-password.tpl" );
		$this->view->render( "App/Views/AccountManager.php" );
	}


	public function invalidToken()
	{
		$this->view->setTemplate( "account-manager/invalid-token.tpl" );
		$this->view->render( "App/Views/AccountManager.php" );
	}

	public function upgradeAction()
	{
		$input = $this->load( "input" );
		$inputValidator = $this->load( "input-validator" );
		$businessRepo = $this->load( "business-repository" );
		$customerRepo = $this->load( "customer-repository" );
		$productRepo = $this->load( "product-repository" );
		$orderRepo = $this->load( "order-repository" );
		$orderProductRepo = $this->load( "order-product-repository" );
		$accessControl = $this->load( "access-control" );

		if ( !$accessControl->hasAccess( [ "administrator" ], $this->user->role ) ) {
			$this->view->render403();
		}

		// Track with facebook pixel
		$Config = $this->load( "config" );
		$facebookPixelBuilder = $this->load( "facebook-pixel-builder" );

		$facebookPixelBuilder->addPixelID( $Config::$configs[ "facebook" ][ "jjs_pixel_id" ] );
		$facebookPixelBuilder->addEvent([
			"ViewContent"
		]);
		$this->view->assign( "facebook_pixel", $facebookPixelBuilder->build() );

		if ( $input->exists() && $inputValidator->validate(

				$input,

				[
					"token" => [
						"equals-hidden" => $this->session->getSession( "csrf-token" ),
						"required" => true
					],
					"product_id" => [
						"required" => true
					],
				],

				"upgrade_account" /* error index */
			) )
		{
			// Get all businesses associated with this account. The quantity
			// of the orderProducts will reflect the number of businesses
			// returned
			$businesses = $businessRepo->get( [ "*" ], [ "account_id" => $this->account->id ] );

			// Verify that all product ids returned are valid products
			$product_ids = [];
			$products = [];
			$all_product_ids = [];
			$all_products = $productRepo->get( [ "*" ] );
			$product_id = $input->get( "product_id" );
			$product_ids[] = $product_id;

			// Quantity will be number of businesses
			$quantity = count( $businesses );
			// Add multiple instances of the same product to the
			// product ids array.Create an array of the products and
			// dynamically add a description with the related businesses
			foreach ( $product_ids as $product_id ) {
				$product = $productRepo->get( [ "*" ], [ "id" => $product_id ], "single" );
				$original_description = $product->description;
				// Reset product description
				$product->description = null;

				// Add business anes to product description
				foreach ( $businesses as $business ) {
					$product->description = $product->description . " | " . $business->business_name;
				}

				// Append orginal product description
				$product->description = $product->description . $original_description;
				$products[] = $product;
			}

			// Create a list of valid product ids
			foreach ( $all_products as $_product ) {
				$all_product_ids[] = $_product->id;
			}

			// Redirect back to the upgrade page if any submitted product ids
			// are invalid. Someone's messin' about.
			foreach ( $product_ids as $_product_id ) {
				if ( !in_array( $_product_id, $all_product_ids ) ) {
					$this->view->redirect( "account-manager/upgrade" );
				}
			}

			// Get customer resource if one exists.
			$customer = $customerRepo->getByAccountID( $this->account->id );

			// If no valid customer is returned, create a new one
			if ( is_null( $customer->id ) ) {
				$customer = $customerRepo->create( $this->account->id );
			}

			// Check for an upaid order for this customer. If one exists, add
			// the products to the order. If not, create an new order
			$order = $orderRepo->getUnpaidOrderByCustomerID( $customer->id );
			if ( is_null( $order->id ) ) {
				$order = $orderRepo->insert([
					"customer_id" => $customer->id,
					"paid" => 0
				]);
			}

			// Create orderProducts for this order
			foreach ( $products as $product ) {
				$orderProductRepo->create(
					$order->id,
					$product->id,
					$quantity,
					$description = $product->description
				);
			}

			$this->view->redirect( "cart/" );
		}

		$this->view->assign( "csrf_token", $this->session->generateCSRFToken() );
	    $this->view->setErrorMessages( $inputValidator->getErrors() );

		if ( in_array( $this->accountType->id, [ 1, 2, 3 ] ) ) {
			$this->view->setTemplate( "account-manager/upgrade-business.tpl" );
		} else {
			$this->view->setTemplate( "account-manager/upgrade-enterprise.tpl" );
		}

		$this->view->render( "App/Views/AccountManager.php" );
	}

	public function addCreditAction()
	{
		$accessControl = $this->load( "access-control" );
		if ( !$accessControl->hasAccess( [ "administrator", "manager" ], $this->user->role ) ) {
			$this->view->render403();
		}

		// Track with facebook pixel
		$Config = $this->load( "config" );
		$facebookPixelBuilder = $this->load( "facebook-pixel-builder" );

		$facebookPixelBuilder->addPixelID( $Config::$configs[ "facebook" ][ "jjs_pixel_id" ] );
		$facebookPixelBuilder->addEvent([
			"ViewContent"
		]);
		$this->view->assign( "facebook_pixel", $facebookPixelBuilder->build() );

		$this->view->setTemplate( "account-manager/add-credit.tpl" );
		$this->view->render( "App/Views/AccountManager.php" );
	}

	public function logout()
	{
		$userAuth = $this->load( "user-authenticator" );
		$userAuth->logout();
		$this->view->redirect( "" ); // goes home
	}

	public function settingsAction()
	{
		$this->view->redirect( "account-manager/account-settings/", 301 );
	}

}
