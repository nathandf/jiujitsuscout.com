<?php

namespace Controllers;

use \Core\Controller;

class JjsAdmin extends Controller
{

    public function before()
    {
        // Loading services
		$userAuth = $this->load( "user-authenticator" );
		$userRepo = $this->load( "user-repository" );
		// If user not validated with session or cookie, send them to sign in
		if ( !$userAuth->userValidate( [ "jjs-admin" ] ) ) {
			$this->view->redirect( "jjs-admin/sign-in" );
		}
		// User is logged in. Get the user object from the UserAuthenticator service
		$this->user = $userAuth->getUser();
    }

    public function indexAction()
    {
        $accountRepo = $this->load( "account-repository" );
        $userRepo = $this->load( "user-repository" );
        $businessRepo = $this->load( "business-repository" );
        $prospectRepo = $this->load( "prospect-repository" );
        $searchRepo = $this->load( "search-repository" );
        $resultsRepo = $this->load( "result-repository" );
        $phoneRepo = $this->load( "phone-repository" );

        $accounts = $accountRepo->getAll();
        $businesses = $businessRepo->getAll();
        $prospects = $prospectRepo->getAll();
        $noResultProspects = [];
        $searches = $searchRepo->getAll();
        $users = $userRepo->getAll();

        // Remove all JJS Admin users
        foreach ( $users as $key => $user ) {
            if ( $user->user_type == "jjs-admin" ) {
                unset( $users[ $key ] );
            }
        }

        foreach ( $prospects as $prospect ) {
            if ( $prospect->business_id == 0 ) {
                $phone = $phoneRepo->getByID( $prospect->phone_id );
                $prospect->phone = $phone;
                $noResultProspects[] = $prospect;
            }
        }

        $this->view->assign( "accounts", $accounts );
        $this->view->assign( "users", $users );
        $this->view->assign( "businesses", $businesses );
        $this->view->assign( "prospects", $prospects );
        $this->view->assign( "noResultProspects", $noResultProspects );
        $this->view->assign( "searches", $searches );

        $this->view->setTemplate( "jjs-admin/home.tpl" );
        $this->view->render( "App/Views/JJSAdmin.php" );
    }

    public function signIn()
    {
        $input = $this->load( "input" );
		$inputValidator = $this->load( "input-validator" );

		$userAuth = $this->load( "user-authenticator" );

		// If user logged in, send to jjs-admin dashboard
		if ( $userAuth->userValidate( [ "jjs-admin" ] ) ) {
			$this->user = $userAuth->getUser();
			$this->view->redirect( "jjs-admin" );
		}

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
                if ( $userAuth->userValidate( [ "jjs-admin" ] ) ) {
                    $this->view->redirect( "jjs-admin/" );
                } else {
                    $this->view->redirect( "account-manager/" );
                }
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

        $this->view->setTemplate( "jjs-admin/jjs-admin-sign-in.tpl" );
        $this->view->render( "App/Views/JJSAdmin.php" );
    }

    public function businessesAction()
    {
        $businessRepo = $this->load( "business-repository" );
        $phoneRepo = $this->load( "phone-repository" );


        $businesses = $businessRepo->getAll();

        // Load businesses phone resoure by phone_id and assign to business object
        foreach ( $businesses as $business ) {
            $phone = $phoneRepo->getByID( $business->phone_id );
            $business->phone = $phone;
        }

        $this->view->assign( "businesses", $businesses );

        $this->view->setTemplate( "jjs-admin/businesses.tpl" );
        $this->view->render( "App/Views/JJSAdmin.php" );
    }

    public function leadsAction()
    {
        $businessRepo = $this->load( "business-repository" );
        $prospectRepo = $this->load( "prospect-repository" );
        $phoneRepo = $this->load( "phone-repository" );

        $prospects = array_reverse( $prospectRepo->getAll() );

        // Remove all prospects not connected to a business
        foreach ( $prospects as $key => $prospect ) {
            if ( $prospect->business_id == 0 ) {
                unset( $prospects[ $key ] );
            }
        }

        $businesses = $businessRepo->getAll();
        $businessNamesByID = [];

        // Create an array of business names indexed by business id
        foreach ( $businesses as $business ) {
            $businessNamesByID[ $business->id ] = $business->business_name;
        }

        // Load prospect phone resoure by phone_id and assign to prospect object
        $i = 0;
        foreach ( $prospects as $prospect ) {
            if ( $i > 100 ) {
                break;
            }
            $phone = $phoneRepo->getByID( $prospect->phone_id );
            $prospect->phone = $phone;
            $prospect->business_name = $businessNamesByID[ $prospect->business_id ];
            $i++;
        }

        $this->view->assign( "prospects", $prospects );
        $this->view->assign( "businesses", $businesses );

        $this->view->setTemplate( "jjs-admin/leads.tpl" );
        $this->view->render( "App/Views/JJSAdmin.php" );
    }

    public function appraisalsAction()
    {
        $businessRepo = $this->load( "business-repository" );
        $prospectAppraisalRepo = $this->load( "prospect-appraisal-repository" );
        $prospectPurchaseRepo = $this->load( "prospect-purchase-repository" );
        $prospectRepo = $this->load( "prospect-repository" );

        $prospectAppraisals = array_reverse( $prospectAppraisalRepo->getAll() );

        foreach ( $prospectAppraisals as $prospectAppraisal ) {
            $prospectAppraisal->prospect = $prospectRepo->getByID( $prospectAppraisal->prospect_id );
            $prospectAppraisal->purchase = $prospectPurchaseRepo->getByProspectID( $prospectAppraisal->prospect_id );
        }

        $this->view->assign( "prospectAppraisals", $prospectAppraisals );

        $this->view->setTemplate( "jjs-admin/appraisals.tpl" );
        $this->view->render( "App/Views/JJSAdmin.php" );
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
					<a href='https://jiujitsuscout.com/jjs-admin/password-reset-validation?reset_token={$nonceToken->value}'>https://www.jiujitsuscout.com/jjs-admin/password-reset-validation?reset_token={$nonceToken->value}</a>
					<br><br>
					If you did not send a password reset request, ignore this message.
				" );
				$mailer->mail();

				$this->view->redirect( "jjs-admin/forgot-password" );
			}
		}

		$this->view->assign( "csrf_token", $this->session->generateCSRFToken() );
		$this->view->setErrorMessages( $inputValidator->getErrors() );

		$this->view->setTemplate( "jjs-admin/forgot-password.tpl" );
		$this->view->render( "App/Views/JJSAdmin.php" );
	}

	public function passwordResetValidation()
	{
		$input = $this->load( "input" );
		$inputValidator = $this->load( "input-validator" );
		$nonceTokenRepo = $this->load( "nonce-token-repository" );
		$passwordResetRepo = $this->load( "password-reset-repository" );
		$userRepo = $this->load( "user-repository" );
		$userAuthenticator = $this->load( "user-authenticator" );

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
				$this->view->redirect( "jjs-admin/invalid-token" );
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
				$this->view->redirect( "jjs-admin/sign-in" );
			}
		}

		$this->view->assign( "csrf_token", $this->session->generateCSRFToken() );
		$this->view->setErrorMessages( $inputValidator->getErrors() );

		$this->view->setTemplate( "jjs-admin/reset-password.tpl" );
		$this->view->render( "App/Views/JJSAdmin.php" );
	}

    public function searchResultsAction()
    {
        $searchRepo = $this->load( "search-repository" );
        $resultRepo = $this->load( "result-repository" );

        // Load searches. Order newest to oldest
        $searches = array_reverse( $searchRepo->getAll() );

        // Load all results for searches
        foreach ( $searches as $search ) {
            $result = $resultRepo->getBySearchID( $search->id );
            $search->result = $result;
        }

        $this->view->assign( "searches", $searches );

        $this->view->setTemplate( "jjs-admin/searches.tpl" );
        $this->view->render( "App/Views/JJSAdmin.php" );

    }

    public function blogsAction()
    {
        $blogRepo = $this->load( "blog-repository" );

        $blogs = $blogRepo->getAll();

        $this->view->assign( "blogs", $blogs );

        $this->view->setTemplate( "jjs-admin/blogs.tpl" );
        $this->view->render( "App/Views/JJSAdmin.php" );

    }

    public function createBlog()
    {
        $input = $this->load( "input" );
        $inputValidator = $this->load( "input-validator" );
        $blogRepo = $this->load( "blog-repository" );
        $imageRepo = $this->load( "image-repository" );

        $images = $imageRepo->getAllByBusinessID( 0 );

        if (
            $input->exists() &&
            $input->issetField( "create" ) &&
            $inputValidator->validate(
                $input,
                [
                    "token" => [
                        "equals-hidden" => $this->session->getSession( "csrf-token" ),
                        "required" => true
                    ],
                    "name" => [
                        "name" => "Blog Name",
                        "required" => true,
                        "min" => 1,
                        "max" => 256
                    ],
                    "url" => [
                        "name" => "Blog URL",
                        "required" => true,
                        "min" => 1,
                        "max" => 256
                    ],
                    "title" => [
                        "name" => "Title",
                        "required" => true,
                    ],
                    "description" => [
                        "name" => "Description",
                        "required" => true
                    ],
                    "image_id" => [
                        "name" => "Image",
                        "required" => true
                    ]
                ],

                "create"
            )
        ) {
            $blog = $blogRepo->create( $input->get( "name" ), $input->get( "url" ), $input->get( "title" ), $input->get( "description" ), $input->get( "image_id" ) );
            $this->view->redirect( "jjs-admin/blog/" . $blog->id . "/" );
        }

        $this->view->assign( "csrf_token", $this->session->generateCSRFToken() );
	    $this->view->setErrorMessages( $inputValidator->getErrors() );

        $this->view->assign( "images", $images );

        $this->view->setTemplate( "jjs-admin/create-blog.tpl" );
        $this->view->render( "App/Views/JJSAdmin.php" );
    }

	public function invalidToken()
	{
		$this->view->setTemplate( "jjs-admin/invalid-token.tpl" );
		$this->view->render( "App/Views/JJSAdmin.php" );
	}

    public function logout()
	{
		$userAuth = $this->load( "user-authenticator" );
		$userAuth->logout();
		$this->view->redirect( "jjs-admin/sign-in" );
	}

}
