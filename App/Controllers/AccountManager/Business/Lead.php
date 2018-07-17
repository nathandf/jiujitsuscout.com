<?php

namespace Controllers\AccountManager\Business;

use Core\Controller;

class Lead extends Controller
{
    private $accountRepo;
    private $account;
    private $businessRepo;
    private $business;
    private $userRepo;
    private $user;
    private $prospectRepo;
    private $smsMessageRepo;

    public function before()
    {
        $this->requireParam( "id" );
        // Loading services
        $userAuth = $this->load( "user-authenticator" );
        $accountRepo = $this->load( "account-repository" );
        $accountUserRepo = $this->load( "account-user-repository" );
        $businessRepo = $this->load( "business-repository" );
        $userRepo = $this->load( "user-repository" );
        $phoneRepo = $this->load( "phone-repository" );
        $prospectRepo = $this->load( "prospect-repository" );
        $this->smsMessageRepo = $this->load( "sms-message-repository" );
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
        $this->business = $businessRepo->getByID( $this->user->getCurrentBusinessID() );
        // Verify that this lead is owned by this business
        $leads = $prospectRepo->getAllByBusinessID( $this->business->id );
        $lead_ids = [];
        foreach ( $leads as $lead ) {
            $lead_ids[] = $lead->id;
        }
        if ( !in_array( $this->params[ "id" ], $lead_ids ) ) {
            $this->view->redirect( "account-manager/business/leads" );
        }
        // Load prospects by type associated with business
        $this->lead = $prospectRepo->getByID( $this->params[ "id" ] );
        // Load lead's phone object
        $this->phone = $phoneRepo->getByID( $this->lead->phone_id );
        // Set lead's phone number
        $this->lead->setPhoneNumber( $this->phone->country_code, $this->phone->national_number );

        $this->view->assign( "account", $this->account );
        $this->view->assign( "user", $this->user );
        $this->view->assign( "business", $this->business );
        $this->view->assign( "lead", $this->lead );
    }

    public function indexAction()
    {
        $noteRepo = $this->load( "note-repository" );
        $appointmentRepo = $this->load( "appointment-repository" );
        $input = $this->load( "input" );
        $inputValidator = $this->load( "input-validator" );
        $noteRepo = $this->load( "note-repository" );
        $noteRegistrar = $this->load( "note-registrar" );
        $prospectRepo = $this->load( "prospect-repository" );
        $groupRepo = $this->load( "group-repository" );
        $mailer = $this->load( "mailer" );

        // Load all notes
        $notes = $noteRepo->getAllByProspectID( $this->lead->id );

        // Create a list of all note ids.
        $note_ids = [];
        foreach ( $notes as $note ) {
            $note_ids[] = $note->id;
        }

        // Load all appointments
        $appointments_all = $appointmentRepo->getAllByProspectID( $this->lead->id );

        // Filter appointments by status. Put pending appointments in appointments array
        $appointments = [];
        foreach ( $appointments_all as $appointment ) {
            if ( $appointment->status == "pending" ) {
                $appointments[] = $appointment;
            }
        }

        // Load all groups
        $groupsAll = $groupRepo->getAllByBusinessID( $this->business->id );
        $groups = [];
        $group_ids = explode( ",", $this->lead->group_ids );
        foreach ( $groupsAll as $group ) {
            if ( in_array( $group->id, $group_ids ) ) {
                $groups[] = $group;
            }
        }

        // Set variables for sending an email
        $recipient_first_name = $this->lead->first_name;
        $recipient_email = $this->lead->email;
        $sender_first_name = $this->user->first_name;
        $sender_email = $this->user->email;

        // If validation rules are passed, send an email
        if ( $input->exists() &&  $input->issetField( "send_email" ) && $inputValidator->validate(

                $input,

                [
                    "token" => [
                        "equals-hidden" => $this->session->getSession( "csrf-token" ),
                        "required" => true
                    ],
                    "subject" => [
                        "name" => "Subject",
                        "required" => true,
                        "min" => 1,
                        "max" => 500
                    ],
                    "body" => [
                        "name" => "Email Body",
                        "required" => true,
                        "min" => 1,
                        "max" => 1000
                    ]
                ],

                "send_email" /* error index */
            ) )
        {
            // Prospect must have an email address to which to send the email
            if ( is_null( $this->lead->email ) || $this->lead->email == "" ) {
                $this->view->redirect( "account-manager/business/lead/" . $this->lead->id . "/?error=invalid_email" );
            }
            // Send email
            $email_subject = $input->get( "subject" );
            $email_body = $input->get( "body" );
            $mailer->setRecipientName( $recipient_first_name );
            $mailer->setRecipientEmailAddress( $recipient_email );
            $mailer->setSenderName( $sender_first_name );
            $mailer->setSenderEmailAddress( $sender_email );
            $mailer->setContentType( "text/html" );
            $mailer->setEmailSubject( $email_subject );
            $mailer->setEmailBody( $email_body );
            $mailer->mail();

            // Record email interaction
            $prospectRepo->updateTimesContactedByID( ( $this->lead->times_contacted + 1 ), $this->lead->id );

            // Create a note for this interaction
            $note_body = "Sent with JiuJitsuScout: " . $input->get( "body" );
            $noteRegistrar->save( $note_body, $this->business->id, $this->user->id, $this->lead->id );
            $this->view->redirect( "account-manager/business/lead/" . $this->lead->id . "/" );
        }

        // Add a note to the database if validation passes
        if ( $input->exists() && $input->issetField( "add_note" ) && $inputValidator->validate(

                $input,

                [
                    "token" => [
                        "equals-hidden" => $this->session->getSession( "csrf-token" ),
                        "required" => true
                    ],
                    "body" => [
                        "name" => "Note body",
                        "required" => true,
                        "min" => 1,
                        "max" => 1000
                    ]
                ],

                "add_note" /* error index */
            ) )
        {
            $noteRegistrar->save( $input->get( "body" ), $this->business->id, $this->user->id, $this->lead->id );
            $this->view->redirect( "account-manager/business/lead/" . $this->params[ "id" ] . "/" );
        }

        // Delete note from database if validation passes
        if ( $input->exists() && $input->issetField( "delete_note" ) && $inputValidator->validate(

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
            $this->view->redirect( "account-manager/business/lead/" . $this->params[ "id" ] . "/#notes" );
        }

        // Record an in interation between a user and prospect upon successful validation
        if ( $input->exists() && $input->issetField( "record_interaction" ) && $inputValidator->validate(

                $input,

                [
                    "token" => [
                        "equals-hidden" => $this->session->getSession( "csrf-token" ),
                        "required" => true
                    ],
                    "record_interaction" => [
                        "name" => "Interaction Type",
                        "required" => true
                    ]
                ],

                "record_interaction" /* error index */
            ) )
        {
            $prospectRepo->updateTimesContactedByID( ( $this->lead->times_contacted + 1 ), $this->lead->id );
            switch ( $input->get( "record_interaction" ) ) {
                case "call":
                    $contact_action = "called";
                    break;
                case "text":
                    $contact_action = "sent a text message to";
                    break;
                case "voicemail":
                    $contact_action = "left a voicemail for";
                    break;
                case "email":
                    $contact_action = "sent an email to";
                    break;
            }
            $note_body = $this->user->first_name . " " . $contact_action . " " . $this->lead->first_name;
            $noteRegistrar->save( $note_body, $this->business->id, $this->user->id, $this->lead->id );
            $this->view->redirect( "account-manager/business/lead/" . $this->lead->id . "/" );
        }

        // Update lead's status on successful validation
        if ( $input->exists() && $input->issetField( "update_status" ) && $inputValidator->validate(

                $input,

                [
                    "token" => [
                        "equals-hidden" => $this->session->getSession( "csrf-token" ),
                        "required" => true
                    ],
                    "update_status" => [
                        "name" => "Status",
                        "required" => true
                    ]
                ],

                "update_status" /* error index */
            ) )
        {
            if ( $input->get( "update_status" ) == "lost" ) {
                $prospectRepo->updateStatusByID( "lost", $this->lead->id );
                $this->view->redirect( "account-manager/business/lead/" . $this->lead->id . "/" );
            }
        }

        // Set variables to populate inputs after form submission failure and assign to view
        $inputs = [];
        // add_note
        if ( $input->issetField( "add_note" ) ) {
            $inputs[ "add_note" ][ "body" ] = $input->get( "body" );
        }

        // Input values submitted from form
        $this->view->assign( "inputs", $inputs );

        // Set CSRF token and assign to view
        $csrf_token = $this->session->generateCSRFToken();
        $this->view->assign( "csrf_token", $csrf_token );
        $this->view->setErrorMessages( $inputValidator->getErrors() );
        $this->view->setFlashMessages( $this->session->getFlashMessages( "flash_messages" ) );

        // where the form should get posted to
        $this->view->assign( "action", HOME . "account-manager/business/lead/" . $this->lead->id . "/" );

        $this->view->assign( "recipient_first_name", $recipient_first_name );
        $this->view->assign( "recipient_email", $recipient_email );
        $this->view->assign( "sender_first_name", $sender_first_name );
        $this->view->assign( "sender_email", $sender_email );

        $this->view->assign( "groups", $groups );
        $this->view->assign( "appointments", $appointments );
        $this->view->assign( "notes", $notes );

        $this->view->setTemplate( "account-manager/business/lead/lead.tpl" );
        $this->view->render( "App/Views/AccountManager/Business/Lead.php" );
    }

    public function editAction()
    {

        $input = $this->load( "input" );
        $inputValidator = $this->load( "input-validator" );
        $prospectRepo = $this->load( "prospect-repository" );
        $phoneRepo = $this->load( "phone-repository" );
        $countryRepo = $this->load( "country-repository" );
        $entityFactory = $this->load( "entity-factory" );
        $appointmentRepo = $this->load( "appointment-repository" );

        $phone = $phoneRepo->getByID( $this->lead->phone_id );

        $country = $countryRepo->getByISO( $this->account->country );

        $countries = $countryRepo->getAll();

        $prospectsAll = $prospectRepo->getAllByBusinessID( $this->business->id );
        $prospect_ids = [];
        foreach ( $prospectsAll as $prospect ) {
            $prospect_ids[] = $prospect->id;
        }

        if ( $input->exists() && $input->issetField( "update_prospect" ) && $inputValidator->validate( $input,
                [
                    "token" => [
                        "equals-hidden" => $this->session->getSession( "csrf-token" ),
                        "required" => true
                    ],
                    "update_prospect" => [
                        "required" => true
                    ],
                    "first_name" => [
                        "name" => "First Name",
                        "required" => true
                    ],
                    "last_name" => [
                        "name" => "Last Name",
                    ],
                    "email" => [
                        "name" => "Email",
                        "email" => true
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
                    "address_1" => [
                        "name" => "Address 1"
                    ],
                    "address_2" => [
                        "name" => "Address 2"
                    ],
                    "city" => [
                        "name" => "City"
                    ],
                    "region" => [
                        "name" => "Region"
                    ]
                ],

                "edit" /* error index */
            ) )
        {
            $prospect = $entityFactory->build( "Prospect" );
            $prospect->first_name = $input->get( "first_name" );
            $prospect->last_name = $input->get( "last_name" );
            $prospect->email = $input->get( "email" );

            $phone->country_code = $input->get( "country_code" );
            $phone->national_number = $input->get( "phone_number" );
            $phoneRepo->updateByID( $phone, $this->lead->phone_id );

            $prospect->address_1 = $input->get( "address_1" );
            $prospect->address_2 = $input->get( "address_2" );
            $prospect->city = $input->get( "city" );
            $prospect->region = $input->get( "region" );
            $prospectRepo->updateProspectByID( $this->lead->id, $prospect );
            $this->view->redirect( "account-manager/business/lead/" . $this->lead->id . "/edit" );
        }

        if ( $input->exists() && $input->issetField( "trash" ) && $inputValidator->validate(

                $input,

                [
                    "token" => [
                        "equals-hidden" => $this->session->getSession( "csrf-token" ),
                        "required" => true
                    ],
                    "trash" => [
                        "required" => true
                    ],
                    "prospect_id" => [
                        "required" => true,
                        "in_array" => $prospect_ids
                    ]
                ],

                "trash_prospect" /* error */
            ) )
        {
            // Change lead status to trash
            $prospectRepo->updateStatusByID( "trash", $input->get( "prospect_id" ) );
            $prospectRepo->updateTypeByID( "trash", $input->get( "prospect_id" ) );

            // Remove group ids
            $prospectRepo->updateGroupIDsByID( "", $input->get( "prospect_id" ) );

            // Remove appointments
            $appointmentRepo->removeByProspectID( $input->get( "prospect_id" ) );

            $this->view->redirect( "account-manager/business/leads" );
        }

        $this->view->assign( "phone", $phone );
        $this->view->assign( "countries", $countries );
        $this->view->assign( "lead", $this->lead );

        $csrf_token = $this->session->generateCSRFToken();
        $this->view->assign( "csrf_token", $csrf_token );
        $this->view->setErrorMessages( $inputValidator->getErrors() );

        $this->view->setTemplate( "account-manager/business/lead/edit.tpl" );
        $this->view->render( "App/Views/AccountManager/Business/Lead.php" );
    }

    public function appointmentsAction()
    {
        $input = $this->load( "input" );
        $inputValidator = $this->load( "input-validator" );
        $timeManager = $this->load( "time-manager" );
        // Load appointments
        $appointmentRepo = $this->load( "appointment-repository" );
        $appointments = $appointmentRepo->getAllByProspectID( $this->lead->id );

        $appointments_by_time = [];
        $appointments_by_time[ "today" ] = [];
        $appointments_by_time[ "tomorrow" ] = [];
        $appointments_by_time[ "past" ] = [];
        $appointments_by_time[ "this_week" ] = [];
        $appointments_by_time[ "next_week" ] = [];
        $appointments_by_time[ "upcoming" ] = [];

        $filter = "pending";
        if ( $input->exists( "get" ) && $input->issetField( "show" ) ) {
            if ( $input->get( "show" ) == "missed" ) {
                $filter = "missed";
            } elseif ( $input->get( "show" ) == "showed" ) {
                $filter = "showed";
            }
        }

        $appointments_total = 0;

        foreach ( $appointments as $appointment ) {
            if ( $appointment->status == $filter ) {
                if ( $timeManager->isToday( $appointment->appointment_time ) ) {
                    $appointments_by_time[ "today" ][] = $appointment;
                } elseif ( $timeManager->isTomorrow( $appointment->appointment_time ) ) {
                    $appointments_by_time[ "tomorrow" ][] = $appointment;
                } elseif ( $timeManager->isPast( $appointment->appointment_time ) ) {
                    $appointments_by_time[ "past" ][] = $appointment;
                } elseif ( $timeManager->isThisWeek( $appointment->appointment_time ) ) {
                    $appointments_by_time[ "this_week" ][] = $appointment;
                } elseif ( $timeManager->isNextWeek( $appointment->appointment_time ) ) {
                    $appointments_by_time[ "next_week" ][] = $appointment;
                } elseif ( $timeManager->isFuture( $appointment->appointment_time ) ) {
                    $appointments_by_time[ "upcoming" ][] = $appointment;
                }

                $appointments_total++;
            }
        }

        $this->view->assign( "appointments_total", $appointments_total );
        $this->view->assign( "appointments_by_time", $appointments_by_time );
        $this->view->assign( "lead", $this->lead );

        $csrf_token = $this->session->generateCSRFToken();
        $this->view->assign( "csrf_token", $csrf_token );
        $this->view->setErrorMessages( $inputValidator->getErrors() );

        $this->view->setTemplate( "account-manager/business/lead/appointments.tpl" );
        $this->view->render( "App/Views/AccountManager/Business/Lead.php" );
    }

    public function trialAction()
    {
        $input = $this->load( "input" );
        $inputValidator = $this->load( "input-validator" );
        $prospectRepo = $this->load( "prospect-repository" );

        if ( $input->exists() && $inputValidator->validate(

                $input,

                [
                    "token" => [
                        "equals-hidden" => $this->session->getSession( "csrf-token" ),
                        "required" => true
                    ],
                    "quantity" => [
                        "name" => "Quantity",
                        "required" => true
                    ],
                    "unit" => [
                        "name" => "Unit",
                        "required" => true
                    ]
                ],

                "update_trial" /* error index */
            ) )
        {
            $quantity = $input->get( "quantity" );
            $unit = $input->get( "unit" );

            if ( $unit == "day" ) {
                $trial_extension = ( 60 * 60 * 24 ) * $quantity;
            } elseif ( $unit == "week" ) {
                $trial_extension = ( 60 * 60 * 24 * 7 ) * $quantity;
            } elseif ( $unit == "month" ) {
                $trial_extension = ( 60 * 60 * 24 * 30 ) * $quantity;
            }

            $new_end_date = $this->lead->trial_end + $trial_extension;
            $prospectRepo->updateTrialTimesByID( $this->lead->id, $this->lead->trial_start,$new_end_date );
            $prospectRepo->updateTrialRemindStatusByID( $this->lead->id, 0 );

            $this->view->redirect( "account-manager/business/lead/" . $this->lead->id . "/trial" );
        }

        $csrf_token = $this->session->generateCSRFToken();
        $this->view->assign( "csrf_token", $csrf_token );
        $this->view->setErrorMessages( $inputValidator->getErrors() );

        $this->view->setTemplate( "account-manager/business/lead/trial.tpl" );
        $this->view->render( "App/Views/AccountManager/Business/Lead.php" );
    }

    public function groupsAction()
    {
        $input = $this->load( "input" );
        $inputValidator = $this->load( "input-validator" );
        $groupRepo = $this->load( "group-repository" );
        $prospectRepo = $this->load( "prospect-repository" );

        $all_groups = $groupRepo->getAllByBusinessID( $this->business->id );

        $lead_group_ids = explode( ",", $this->lead->group_ids );

        if ( $input->exists() ) {
            $group_ids = null;
            if ( $input->issetField( "group_ids" ) ) {
                $group_ids = implode( ",", $input->get( "group_ids" ) );
            }
            $prospectRepo->updateGroupIDsByID( $group_ids, $this->params[ "id" ] );

            $this->view->redirect( "account-manager/business/lead/" . $this->lead->id . "/groups" );
        }

        foreach ( $all_groups as $group ) {
            $group->isset = false;
            if ( in_array( $group->id, $lead_group_ids ) ) {
                $group->isset = true;
            }
        }

        $this->view->assign( "groups", $all_groups );

        $this->view->setTemplate( "account-manager/business/lead/groups.tpl" );
        $this->view->render( "App/Views/AccountManager/Business/Lead.php" );
    }

    public function sendSMSAction()
    {
        $input = $this->load( "input" );
        $inputValidator = $this->load( "input-validator" );
        $smsMessager = $this->load( "sms-messager" );
        if ( $input->exists() && $inputValidator->validate( $input, [ "sms_body" ] ) ) {
            $entityFactory = $this->load( "entity-factory" );
            $smsMessage = $entityFactory->build( "SMSMessage" );
            $this->smsMessageRepo->save( $smsMessage,
                [
                    "sender_country_code" => "+1",
                    "sender_phone_number" => $this->user->phone_number,
                    "recipient_country_code" => "+1",
                    "recipient_phone_number" => $this->lead->phone_number,
                    "sms_body" => $input->get( "sms_body" ),
                    "utc_time_sent" => time()
                ]
            );

            $smsMessager->send( $smsMessage );
        }
    $this->view->redirect( "account-manager/business/lead/" . $this->lead->id . "/#conversation-box" );
    }

}
