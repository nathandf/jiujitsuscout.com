<?php

namespace Controllers\AccountManager\Business;

use Core\Controller;

class Appointment extends Controller
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
        $prospectRepo = $this->load( "prospect-repository" );
        $appointmentRepo = $this->load( "appointment-repository" );
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
        // Verify that this business owns this appointment
        $appointments = $appointmentRepo->getAllByBusinessID( $this->business->id );
        $appointment_ids = [];
        foreach ( $appointments as $appointment ) {
            $appointment_ids[] = $appointment->id;
        }
        if ( isset( $this->params[ "id" ] ) && !in_array( $this->params[ "id" ], $appointment_ids ) ) {
            $this->view->redirect( "account-manager/business/appointments" );
        }
        // Load prospects by type associated with business
        $this->leads = $prospectRepo->getAllByStatusAndBusinessID( "pending", $this->business->id );
        // Assign phone asset to lead
        foreach ( $this->leads as $lead ) {
            $phone = $phoneRepo->getByID( $lead->phone_id );
            $lead->phone_number = "+" . $phone->country_code . " " . $phone->national_number;
        }
        // Set data for the view
        $this->view->assign( "page", "appointment" );
        $this->view->assign( "leads", $this->leads );
        $this->view->assign( "account", $this->account );
        $this->view->assign( "user", $this->user );
        $this->view->assign( "business", $this->business );
    }

    public function indexAction()
    {
        if ( !$this->issetParam( "id" ) ) {
            $this->view->redirect( "account-manager/business/appointment/new" );
        }

        $input = $this->load( "input" );
        $inputValidator = $this->load( "input-validator" );
        $appointmentRepo = $this->load( "appointment-repository" );
        $prospectRepo = $this->load( "prospect-repository" );
        $noteRegistrar = $this->load( "note-registrar" );
        $noteRepo = $this->load( "note-repository" );

        $appointment = $appointmentRepo->getByID( $this->params[ "id" ] );
        $lead = $prospectRepo->getByID( $appointment->prospect_id );

        // Get all appointments and create a list of appointment ids
        $appointmentsAll = $appointmentRepo->getAllByBusinessID( $this->business->id );
        $appointment_ids = [];

        foreach ( $appointmentsAll as $_appointment ) {
            $appointment_ids[] = $_appointment->id;
        }

        // Get all notes for this appointment
        $notes = $noteRepo->getAllByAppointmentID( $this->params[ "id" ] );

        // Create a list of all note ids.
        $note_ids = [];
        foreach ( $notes as $note ) {
            $note_ids[] = $note->id;
        }

        if ( $input->exists() ) {
            if ( $input->issetField( "update_status" ) && $inputValidator->validate( $input,
                    [
                        "token" => [
                            "equals-hidden" => true,
                            "required" => true
                        ],
                        "status" => [
                            "required" => true
                        ],
                    ], null // error index
                ) )
            {
                $appointmentRepo->updateStatusByID( $this->params[ "id" ], $input->get( "status" ) );
                $this->view->redirect( "account-manager/business/appointment/" . $this->params[ "id" ] . "/" );
            } elseif ( $input->issetField( "reschedule" ) && $inputValidator->validate( $input,
                    [
                        "token" => [
                            "equals-hidden" => $this->session->getSession( "csrf-token" ),
                            "required" => true
                        ],
                        "reschedule" => [
                            "required" => true
                        ],
                        "Date_Month" => [
                            "required" => true
                        ],
                        "Date_Day" => [
                            "required" => true
                        ],
                        "Date_Year" => [
                            "required" => true
                        ],
                        "Time_Hour" => [
                            "required" => true
                        ],
                        "Time_Minute" => [
                            "required" => true
                        ],
                        "Time_Meridian" => [
                            "required" => true
                        ]
                    ], "update_appointment" // error index
                ) )
            {
                $month = $input->get( "Date_Month" );
                $day = $input->get( "Date_Day" );
                $year = $input->get( "Date_Year" );
                $hour = $input->get( "Time_Hour" );
                $minute = $input->get( "Time_Minute" );
                $meridian = $input->get( "Time_Meridian" );
                $remind_user = false;
                $remind_prospect = false;
                if ( isset( $_GET[ "remind_user" ] ) ) {
                    $remind_user = $input->get( "remind_user" );
                }
                if ( isset( $_GET[ "remind_prospect" ] ) ) {
                    $remind_prospect = $input->get( "remind_prospect" );
                }

                $appointment_time_string = $month . "/" . $day . "/" . $year . " " . $hour . ":" . $minute . $meridian;
                $appointment_time = strtotime( $appointment_time_string );
                $appointmentRepo->updateTimeByID( $this->params[ "id" ], $appointment_time );
                $appointmentRepo->updateStatusByID( $this->params[ "id" ], "pending" );
                $this->view->redirect( "account-manager/business/appointment/" . $this->params[ "id" ] . "/" );

            }

            if ( $input->issetField( "add_note" ) && $inputValidator->validate( $input,
                    [
                        "token" => [
                            "equals-hidden" => $this->session->getSession( "csrf-token" ),
                            "required" => true
                        ],
                        "note_body" => [
                            "name" => "Note",
                            "required" => true,
                            "min" => 1,
                            "max" => 1000
                        ]
                    ], "add_note" // error index
                ) )
            {
                $id = $noteRegistrar->save( $input->get( "note_body" ), $this->business->id, $this->user->id, null, null, $this->params[ "id" ] );
                $this->view->redirect( "account-manager/business/appointment/" . $this->params[ "id" ] . "/#note{$id}" );
            }

            // Delete note from database if validation passes
            if ( $input->issetField( "delete_note" ) && $inputValidator->validate(

                    $input,

                    [
                        "token" => [
                            "equals-hidden" => $this->session->getSession( "csrf-token" ),
                            "required" => true
                        ],
                        "note_id" => [
                            "name" => "Note ID",
                            "required" => true,
                            "in_array" => $note_ids
                        ]
                    ],

                    "delete_note" /* error index */
                ) )
            {
                $noteRepo->removeByID( $input->get( "note_id" ) );
                $this->view->redirect( "account-manager/business/appointment/" . $this->params[ "id" ] . "/#notes" );
            }


            if ( $input->issetField( "trash" ) && $inputValidator->validate(

                    $input,

                    [
                        "token" => [
                            "equals-hidden" => $this->session->getSession( "csrf-token" ),
                            "required" => true
                        ],
                        "trash" => [
                            "required" => true
                        ],
                        "appointment_id" => [
                            "required" => true,
                            "in_array" => $appointment_ids
                        ]
                    ],

                    "trash_appointment" /* error */
                ) )
            {
                // Delete appointment
                $appointmentRepo->removeByID( $input->get( "appointment_id" ) );

                // Delete all notes for this appointment
                $noteRepo->removeAllByAppointmentID( $input->get( "appointment_id" ) );

                $this->view->redirect( "account-manager/business/appointments" );
            }
        }

        $csrf_token = $this->session->generateCSRFToken();
        $this->view->assign( "csrf_token", $csrf_token );
        $this->view->setErrorMessages( $inputValidator->getErrors() );

        $this->view->assign( "appointment", $appointment );
        $this->view->assign( "lead", $lead );
        $this->view->assign( "notes", $notes );

        $this->view->setTemplate( "account-manager/business/appointment/appointment.tpl" );
        $this->view->render( "App/Views/AccountManager/Business/Appointment.php" );
    }

    public function newAction()
    {
        $this->view->setTemplate( "account-manager/business/appointment/choose-prospect.tpl" );
        $this->view->render( "App/Views/AccountManager/Business/Appointment.php" );
    }

    public function scheduleAction()
    {
        $input = $this->load( "input" );
        $inputValidator = $this->load( "input-validator" );
        $appointmentRepo = $this->load( "appointment-repository" );
        $noteRepo = $this->load( "note-repository" );
        $prospectRepo = $this->load( "prospect-repository" );

        $appointmentsAll = $appointmentRepo->getAllByBusinessID( $this->business->id );
        $appointment_ids = [];

        foreach ( $appointmentsAll as $appointment ) {
            $appointment_ids[] = $appointment->id;
        }

        if ( $input->exists( "get" ) && $inputValidator->validate( $input,
                [
                    "prospect_id" => [
                        "required" => true
                     ]
                 ], null // error index
             ) )
        {
            // Verfiy that this business owns this prospect
			$prospects = $prospectRepo->getAllByBusinessID( $this->business->id );
			$prospect_ids = [];
			foreach ( $prospects as $prospect ) {
				$prospect_ids[] = $prospect->id;
			}
			if ( !in_array( $input->get( "prospect_id" ), $prospect_ids ) ) {
				$this->view->redirect( "account-manager/business/appointment/new" );
			}
            $lead = $prospectRepo->getByID( $input->get( "prospect_id" ) );
            $this->view->assign( "lead", $lead );
        } else {
            $this->view->redirect( "account-manager/business/appointment/new" );
        }

        if ( $input->exists( "get" ) && $input->issetField( "schedule" ) && $inputValidator->validate(

                $input,

                [
                    "token" => [
                        "equals-hidden" => $this->session->getSession( "csrf-token" ),
                        "required" => true
                    ],
                    "prospect_id" => [
                        "required" => true
                    ],
                    "Date_Day" => [
                        "required" => true
                    ],
                    "Date_Month" => [
                        "required" => true
                    ],
                    "Date_Year" => [
                        "required" => true
                    ],
                    "Time_Hour" => [
                        "required" => true
                    ],
                    "Time_Minute" => [
                        "required" => true
                    ],
                    "Time_Meridian" => [
                        "required" => true
                    ]
                ], "schedule_appointment" // error index
            ) )
        {
            $prospect_id = $input->get( "prospect_id" );
            $month = $input->get( "Date_Month" );
            $day = $input->get( "Date_Day" );
            $year = $input->get( "Date_Year" );
            $hour = $input->get( "Time_Hour" );
            $minute = $input->get( "Time_Minute" );
            $meridian = $input->get( "Time_Meridian" );
            $message = $input->get( "message" );
            $remind_user = false;
            $remind_prospect = false;
            if ( isset( $_GET[ "remind_user" ] ) ) {
                $remind_user = $input->get( "remind_user" );
            }
            if ( isset( $_GET[ "remind_prospect" ] ) ) {
                $remind_prospect = $input->get( "remind_prospect" );
            }

            $appointment_time_string = $month . "/" . $day . "/" . $year . " " . $hour . ":" . $minute . $meridian;
            $appointment_time = strtotime( $appointment_time_string );

            $appointmentRepo->create( $this->business->id, $this->user->id, $prospect_id, $appointment_time, $message, $remind_user, $remind_prospect );
            $this->view->redirect( "account-manager/business/lead/" . $prospect_id . "/" );
        }

        $this->view->assign( "csrf_token", $this->session->generateCSRFToken() );
        $this->view->setErrorMessages( $inputValidator->getErrors() );

        $this->view->setTemplate( "account-manager/business/appointment/schedule.tpl" );
        $this->view->render( "App/Views/AccountManager/Business/Appointment.php" );
    }

}
