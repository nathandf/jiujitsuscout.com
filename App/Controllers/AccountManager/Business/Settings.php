<?php

namespace Controllers\AccountManager\Business;

use Core\Controller;

class Settings extends Controller
{

    public function before()
    {
        // Loading services
        $userAuth = $this->load( "user-authenticator" );
        $accountRepo = $this->load( "account-repository" );
        $accountUserRepo = $this->load( "account-user-repository" );
        $this->businessRepo = $this->load( "business-repository" );
        $userRepo = $this->load( "user-repository" );
        $accessControl = $this->load( "access-control" );

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
        $this->business = $this->businessRepo->getByID( $this->user->getCurrentBusinessID() );

        // Restrict entire controller to admins
        if ( !$accessControl->hasAccess( [ "administrator" ], $this->user->role ) ) {
            $this->view->render403();
        }

        // Set data for the view
        $this->view->assign( "account", $this->account );
        $this->view->assign( "user", $this->user );
        $this->view->assign( "business", $this->business );
    }

    public function indexAction()
    {
        $this->view->redirect( "account-manager/business/settings/location" );
    }


    public function locationAction()
    {
        $input = $this->load( "input" );
        $inputValidator = $this->load( "input-validator" );
        $countryRepo = $this->load( "country-repository" );
        $businessRepo = $this->load( "business-repository" );
        $geocoder = $this->load( "geocoder" );

        $countries = $countryRepo->getAll();

        if ( $input->exists() && $inputValidator->validate(

                $input,

                [
                    "token" => [
                        "equals-hidden" => $this->session->getSession( "csrf-token" ),
                        "required" => true
                    ],
                    "update_location" => [
                        "required" => true
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
                    "country" => [
                        "name" => "Country",
                        "required" => true,
                        "max" => 250
                    ]
                ],

                "update_location" /* error index */
            ) )
        {
            $location_details = [
                "address_1" => $input->get( "address_1" ),
                "address_2" => $input->get( "address_2" ),
                "city" => $input->get( "city" ),
                "region" => $input->get( "region" ),
                "postal_code" => $input->get( "postal_code" ),
                "country" => $input->get( "country" )
            ];

            // Get latitude and longitude of new address
            $address = $input->get( "address_1" );
            if ( !empty( $input->get( "address_2" ) ) ) {
                $address = $input->get( "address_1" ) . " " . $input->get( "address_2" );
            }

            $full_address = $address . " " . $input->get( "city" ) . ", " . $input->get( "region" ) . " " . $input->get( "postal_code" ) . ", " . $input->get( "country" );

            $geoInfo = $geocoder->getGeoInfoByAddress( $full_address );

            // Save new latitude and longitude
            $businessRepo->updateLatitudeLongitudeByID( $this->business->id, $geoInfo->results[ 0 ]->geometry->location->lat, $geoInfo->results[ 0 ]->geometry->location->lng );

            // Save new location details
            $businessRepo->updateLocationByID( $this->business->id, $location_details );


            $this->view->redirect( "account-manager/business/settings/location" );
        }

        $this->view->assign( "countries", $countries );

        $this->view->assign( "csrf_token", $this->session->generateCSRFToken() );
        $this->view->setErrorMessages( $inputValidator->getErrors() );

        $this->view->setTemplate( "account-manager/business/settings/location.tpl" );
        $this->view->render( "App/Views/AccountManager/Business/Settings.php" );
    }

    public function programsAction()
    {
        // Load services
        $input = $this->load( "input" );
        $inputValidator = $this->load( "input-validator" );
        $programRepository = $this->load( "program-repository" );
        $businessRepo = $this->load( "business-repository" );

        // Get programs from business
        $programs = $programRepository->getAll();
        $business_programs = explode( ",", $this->business->programs );

        // Check which programs the business offers against all available programs
        foreach ( $programs as $program ) {
            if ( in_array( $program->name, $business_programs ) ) {
                $program->isset = true;
            } else {
                $program->isset = false;
            }
        }

        if ( $input->exists() && $inputValidator->validate(

                $input,

                [
                    "token" => [
                        "equals-hidden" => $this->session->getSession( "csrf-token" ),
                        "required" => true
                    ],
                    "update_programs" => [
                        "required" => true
                    ],
                    "programs" => [
                        "is_array" => true
                    ]
                ],

                "update_programs" /* error index */
            ) )
        {
            $programs = [];
            if ( is_array( $input->get( "programs" ) ) ) {
                $programs = $input->get( "programs" );
            }

            $businessRepo->updateProgramsByID( $this->business->id, $programs );
            $this->view->redirect( "account-manager/business/settings/programs" );
        }

        $this->view->assign( "programs", $programs );
        $this->view->assign( "business-programs", $business_programs );

        $this->view->assign( "csrf_token", $this->session->generateCSRFToken() );
        $this->view->setErrorMessages( $inputValidator->getErrors() );

        $this->view->setTemplate( "account-manager/business/settings/programs.tpl" );
        $this->view->render( "App/Views/AccountManager/Business/Settings.php" );
    }

    public function disciplinesAction()
    {
        // Load discipline repo
        $disciplineRepository = $this->load( "discipline-repository" );
        $input = $this->load( "input" );
        $inputValidator = $this->load( "input-validator" );
        $buisnessRepo = $this->load( "business-repository" );

        // Get disciplines from business
        $disciplines = $disciplineRepository->getAll();
        $business_disciplines = explode( ",", $this->business->discipline_ids );

        // Check which disciplines the business offers against all available disciplines
        foreach ( $disciplines as $discipline ) {
            if ( in_array( $discipline->id, $business_disciplines ) ) {
                $discipline->isset = true;
            } else {
                $discipline->isset = false;
            }
        }

        if ( $input->exists() && $inputValidator->validate(

                $input,

                [
                    "token" => [
                        "equals-hidden" => $this->session->getSession( "csrf-token" ),
                        "required" => true
                    ],
                    "update_disciplines" => [
                        "required" => true
                    ],
                    "disciplines" => [
                        "is_array" => true
                    ]
                ],

                "update_disciplines" /* error index */
            ) )
        {
            $disciplines = [];
            if ( is_array( $input->get( "disciplines" ) ) ) {
                $disciplines = $input->get( "disciplines" );
            }

            $this->businessRepo->updateDisciplinesByID( $this->business->id, $disciplines );
            $this->view->redirect( "account-manager/business/settings/disciplines" );
        }

        $this->view->assign( "disciplines", $disciplines );
        $this->view->assign( "business-disciplines", $business_disciplines );

        $this->view->assign( "csrf_token", $this->session->generateCSRFToken() );
        $this->view->setErrorMessages( $inputValidator->getErrors() );

        $this->view->setTemplate( "account-manager/business/settings/disciplines.tpl" );
        $this->view->render( "App/Views/AccountManager/Business/Settings.php" );
    }

    public function contactAction()
    {
        $input = $this->load( "input" );
        $inputValidator = $this->load( "input-validator" );
        $countryRepo = $this->load( "country-repository" );
        $phoneRepo = $this->load( "phone-repository" );
        $factory = $this->load( "entity-factory" );
        $businessRepo = $this->load( "business-repository" );

        $countries = $countryRepo->getAll();

        $phone = $phoneRepo->getByID( $this->business->phone_id );

        if ( $input->exists() && $inputValidator->validate(

                $input,

                [
                    "token" => [
                        "equals-hidden" => $this->session->getSession( "csrf-token" ),
                        "required" => true
                    ],
                    "update_contact_info" => [
                        "required" => true
                    ],
                    "country_code" => [
                        "name" => "Country Code",
                        "required" => true
                    ],
                    "phone_number" => [
                        "name" => "Phone Number",
                        "required" => true,
                        "phone" => true
                    ],
                    "email" => [
                        "name" => "Email",
                        "required" => true,
                        "email" => true
                    ]

                ],

                "update_contact_info" /* error index */
            ) )
        {
            $phone = $factory->build( "Phone" );
            $phone->country_code = $input->get( "country_code" );
            $phone->national_number = $input->get( "phone_number" );

            $businessRepo->updateEmailByID( $this->business->id, $input->get( "email" ) );
            $phoneRepo->updateByID( $phone, $this->business->phone_id );

            $this->view->redirect( "account-manager/business/settings/contact" );
        }

        $this->view->assign( "countries", $countries );
        $this->view->assign( "phone", $phone );

        $this->view->assign( "csrf_token", $this->session->generateCSRFToken() );
        $this->view->setErrorMessages( $inputValidator->getErrors() );

        $this->view->setTemplate( "account-manager/business/settings/contact-info.tpl" );
        $this->view->render( "App/Views/AccountManager/Business/Settings.php" );
    }

    public function notificationsAction()
    {
        // Load services
        $input = $this->load( "input" );
        $inputValidator = $this->load( "input-validator" );
        $accountUserRepo = $this->load( "account-user-repository" );
        $userRepo = $this->load( "user-repository" );
        $businessRepo = $this->load( "business-repository" );

        $accountUsers = $accountUserRepo->getAllByAccountID( $this->account->id );
        $user_ids = [];
        $users = [];
        foreach ( $accountUsers as $accountUser ) {
            $user_ids[] = $accountUser->user_id;
            $users[] = $userRepo->getByID( $accountUser->user_id );
        }

        // Get user notification recipient ids
        $user_notification_recipient_ids = $this->business->user_notification_recipient_ids;
        $user_notification_recipient_ids = explode( ",", $user_notification_recipient_ids );
        // Check which users are on the notification list
        foreach ( $users as $user ) {
            if ( in_array( $user->id, $user_notification_recipient_ids ) ) {
                $user->isset = true;
            } else {
                $user->isset = false;
            }
        }

        if ( $input->exists() && $inputValidator->validate(

                $input,

                [
                    "token" => [
                        "equals-hidden" => $this->session->getSession( "csrf-token" ),
                        "required" => true
                    ],
                    "update_user_ids" => [
                        "required" => true
                    ],
                    "user_ids" => [
                        "is_array" => true
                    ]
                ],

                "update_user_ids" /* error index */
            ) )
        {
            $user_ids = [];
            if ( is_array( $input->get( "user_ids" ) ) ) {
                $user_ids = $input->get( "user_ids" );
            }

            $businessRepo->updateUserNotificationRecipientIDsByID( $this->business->id, $user_ids );
            $this->view->redirect( "account-manager/business/settings/notifications" );
        }

        $this->view->assign( "users", $users );

        $this->view->assign( "csrf_token", $this->session->generateCSRFToken() );
        $this->view->setErrorMessages( $inputValidator->getErrors() );

        $this->view->setTemplate( "account-manager/business/settings/notifications.tpl" );
        $this->view->render( "App/Views/AccountManager/Business/Settings.php" );
    }

}
