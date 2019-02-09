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
        $prospectAppraisalRepo = $this->load( "prospect-appraisal-repository" );
        $prospectPurchaseRepo = $this->load( "prospect-purchase-repository" );
        $currencyRepo = $this->load( "currency-repository" );

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

        // Get business phone object
        $this->business->phone = $phoneRepo->get( [ "*" ], [ "id" => $this->business->phone_id ], "single" );

        // Get currency object for business
        $this->business->currency = $currencyRepo->getByCode( $this->business->currency );
        // Verify that this prospect is owned by this business
        $prospects = $prospectRepo->getAllByBusinessID( $this->business->id );
        $prospect_ids = [];
        foreach ( $prospects as $prospect ) {
            $prospect_ids[] = $prospect->id;
        }
        if ( !in_array( $this->params[ "id" ], $prospect_ids ) ) {
            $this->view->redirect( "account-manager/business/leads" );
        }
        // Load prospects by type associated with business
        $this->prospect = $prospectRepo->getByID( $this->params[ "id" ] );
        // Load prospect's phone object
        $this->phone = $phoneRepo->getByID( $this->prospect->phone_id );
        // Set prospect's phone number
        $this->prospect->setPhoneNumber( $this->phone->country_code, $this->phone->national_number );

        // Get appraisal for prospect if one exists
        $appraisal = $prospectAppraisalRepo->getByProspectID( $this->prospect->id );
        if ( !is_null( $appraisal->id ) ) {
            $this->prospect->appraisal = $appraisal;
        }

        // Get purchase for prospect if one exists
        $purchase = $prospectPurchaseRepo->getByProspectID( $this->prospect->id );
        if ( !is_null( $purchase->id ) ) {
            $this->prospect->purchase = $purchase;
        }

        // Track with facebook pixel
		$Config = $this->load( "config" );
		$facebookPixelBuilder = $this->load( "facebook-pixel-builder" );

		$facebookPixelBuilder->addPixelID( $Config::$configs[ "facebook" ][ "jjs_pixel_id" ] );
		$this->view->assign( "facebook_pixel", $facebookPixelBuilder->build() );

        $this->view->assign( "account", $this->account );
        $this->view->assign( "user", $this->user );
        $this->view->assign( "business", $this->business );
        $this->view->assign( "lead", $this->prospect );
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
        $prospectGroupRepo = $this->load( "prospect-group-repository" );
        $mailer = $this->load( "mailer" );
        $emailTemplateRepo = $this->load( "email-template-repository" );
        $emailerHelper = $this->load( "emailer-helper" );

        // If prospect requires purchase, redirect to purchase page
        if ( isset( $this->prospect->appraisal ) && ( isset( $this->prospect->purchase ) == false ) ) {
            $this->view->redirect( "account-manager/business/lead/" . $this->params[ "id" ] . "/purchase" );
        }

        // Load all notes
        $notes = $noteRepo->getAllByProspectID( $this->prospect->id );

        // Create a list of all note ids.
        $note_ids = [];
        foreach ( $notes as $note ) {
            $note_ids[] = $note->id;
        }

        // Load all appointments
        $appointments_all = $appointmentRepo->getAllByProspectID( $this->prospect->id );

        // Filter appointments by status. Put pending appointments in appointments array
        $appointments = [];
        foreach ( $appointments_all as $appointment ) {
            if ( $appointment->status == "pending" ) {
                $appointments[] = $appointment;
            }
        }

        $prospectGroups = $prospectGroupRepo->get( [ "*" ], [ "prospect_id" => $this->prospect->id ] );
        $groups = [];

        foreach ( $prospectGroups as $prospectGroup ) {
            $group = $groupRepo->get( [ "*" ], [ "id" => $prospectGroup->group_id ], "single" );
            if ( !is_null( $group ) ) {
                $groups[] = $group;
            }
        }

        // Set variables for sending an email
        $emailerHelper->setSenderName( $this->user->first_name );
        $emailerHelper->setSenderEmail( $this->user->email );
        $emailerHelper->setRecipientName( $this->prospect->first_name );
        $emailerHelper->setRecipientEmail( $this->prospect->email );

        // Set email templates if any exist
        $emailerHelper->emailTemplates = $emailTemplateRepo->getAllByBusinessID( $this->business->id );

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
            )
        ) {
            // Prospect must have an email address to which to send the email
            if ( is_null( $this->prospect->email ) || $this->prospect->email == "" ) {
                $this->view->redirect( "account-manager/business/lead/" . $this->prospect->id . "/?error=invalid_email" );
            }
            // Send email
            $mailer->setRecipientName( $emailerHelper->recipient_name );
            $mailer->setRecipientEmailAddress( $emailerHelper->recipient_email );
            $mailer->setSenderName( $emailerHelper->sender_name );
            $mailer->setSenderEmailAddress( $emailerHelper->sender_email );
            $mailer->setContentType( "text/html" );
            $mailer->setEmailSubject( $input->get( "subject" ) );
            $mailer->setEmailBody( $input->get( "body" ) );
            $mailer->mail();

            $this->session->addFlashMessage( "Email Sent" );
            $this->session->setFlashMessages();

            // Record email interaction
            $prospectRepo->updateTimesContactedByID( ( $this->prospect->times_contacted + 1 ), $this->prospect->id );

            // Create a note for this interaction
            $note_body = "Sent with JiuJitsuScout: " . $input->get( "body" );
            $noteRegistrar->save( $note_body, $this->business->id, $this->user->id, $this->prospect->id );

            $this->view->redirect( "account-manager/business/lead/" . $this->prospect->id . "/" );
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
            $noteRegistrar->save( $input->get( "body" ), $this->business->id, $this->user->id, $this->prospect->id );
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
            $prospectRepo->updateTimesContactedByID( ( $this->prospect->times_contacted + 1 ), $this->prospect->id );
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
            $note_body = $this->user->first_name . " " . $contact_action . " " . $this->prospect->first_name;
            $noteRegistrar->save( $note_body, $this->business->id, $this->user->id, $this->prospect->id );
            $this->view->redirect( "account-manager/business/lead/" . $this->prospect->id . "/" );
        }

        // Update prospect's status on successful validation
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
                $prospectRepo->updateStatusByID( "lost", $this->prospect->id );
                $this->view->redirect( "account-manager/business/lead/" . $this->prospect->id . "/" );
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
        $this->view->assign( "csrf_token", $this->session->generateCSRFToken() );
        $this->view->setErrorMessages( $inputValidator->getErrors() );
        $this->view->setFlashMessages( $this->session->getFlashMessages( "flash_messages" ) );

        // where the form should get posted to
        $this->view->assign( "action", HOME . "account-manager/business/lead/" . $this->prospect->id . "/" );

        $this->view->assign( "emailerHelper", $emailerHelper );

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

        $phone = $phoneRepo->getByID( $this->prospect->phone_id );

        $country = $countryRepo->get( [ "*" ], [ "iso" => $this->account->country ], "single" );

        $countries = $countryRepo->get( [ "*" ] );

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
            $phoneRepo->updateByID( $phone, $this->prospect->phone_id );

            $prospect->address_1 = $input->get( "address_1" );
            $prospect->address_2 = $input->get( "address_2" );
            $prospect->city = $input->get( "city" );
            $prospect->region = $input->get( "region" );
            $prospectRepo->updateProspectByID( $this->prospect->id, $prospect );
            $this->view->redirect( "account-manager/business/lead/" . $this->prospect->id . "/edit" );
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
            // Change prospect status to trash
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
        $this->view->assign( "lead", $this->prospect );

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
        $appointments = $appointmentRepo->getAllByProspectID( $this->prospect->id );

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
        $this->view->assign( "lead", $this->prospect );

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

            $new_end_date = $this->prospect->trial_end + $trial_extension;
            $prospectRepo->updateTrialTimesByID( $this->prospect->id, $this->prospect->trial_start,$new_end_date );
            $prospectRepo->updateTrialRemindStatusByID( $this->prospect->id, 0 );

            $this->view->redirect( "account-manager/business/lead/" . $this->prospect->id . "/trial" );
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
        $prospectGroupRepo = $this->load( "prospect-group-repository" );
        $groupRepo = $this->load( "group-repository" );
        $prospectRepo = $this->load( "prospect-repository" );

        $groups = $groupRepo->get( [ "*" ], [ "business_id" => $this->business->id ] );
        $group_ids_all = $groupRepo->get( [ "id" ], [ "business_id" => $this->business->id ], "raw" );
        $prospect_group_group_ids = $prospectGroupRepo->get( [ "group_id" ], [ "prospect_id" => $this->prospect->id ], "raw" );

        foreach ( $groups as $group ) {
            $group->isset = false;
            if ( in_array( $group->id, $prospect_group_group_ids ) ) {
                $group->isset = true;
            }
        }

        if ( $input->exists() && $inputValidator->validate(
                $input,
                [
                    "token" => [
                        "required" => true,
                        "equals-hidden" => $this->session->getSession( "csrf-token" )
                    ]
                ],
                "groups"
            )
        ) {
            // Update group ids
            $submitted_group_ids = [];
            if ( $input->issetField( "group_ids" ) ) {
                $submitted_group_ids = $input->get( "group_ids" );
            }

            // Create and new prospect group for any of the submitted
            // group ids if it doesn't already exist
            foreach ( $submitted_group_ids as $submitted_group_id ) {
                if ( !in_array( $submitted_group_id, $prospect_group_group_ids, true ) ) {
                    $prospectGroupRepo->insert([
                        "prospect_id" => $this->prospect->id,
                        "group_id" => $submitted_group_id
                    ]);
                }
            }

            // Delete the prospect groups with the group ids that were not
            // submitted
            foreach ( $group_ids_all as $_group_id ) {
                if (
                    !in_array( $_group_id, $submitted_group_ids ) &&
                    in_array( $_group_id, $prospect_group_group_ids, true )
                ) {
                    $prospectGroupRepo->delete( [ "group_id", "prospect_id" ], [ $_group_id, $this->params[ "id" ] ] );
                }
            }

            $this->session->addFlashMessage( "Groups Updated" );
            $this->session->setFlashMessages();

            $this->view->redirect( "account-manager/business/lead/" . $this->prospect->id . "/groups" );
        }

        $this->view->assign( "groups", $groups );
        $this->view->assign( "csrf_token", $this->session->generateCSRFToken() );
        $this->view->assign( "flash_messages", $this->session->getFlashMessages() );

        $this->view->setTemplate( "account-manager/business/lead/groups.tpl" );
        $this->view->render( "App/Views/AccountManager/Business/Lead.php" );
    }

    public function purchaseAction()
    {
        // Restrict access to administrators and managers
        $accessControl = $this->load( "access-control" );
        if ( !$accessControl->hasAccess( [ "administrator", "manager" ], $this->user->role ) ) {
            $this->view->render403();
        }

        // If prospect has been appraised and purchased or no appraisal has been made, redirect to the lead profile
        if ( ( isset( $this->prospect->appraisal ) && isset( $this->prospect->purchase ) ) || isset( $this->prospect->appraisal ) == false ) {
            $this->view->redirect( "account-manager/business/lead/" . $this->prospect->id . "/" );
        }

        $input = $this->load( "input" );
        $inputValidator = $this->load( "input-validator" );
        $respondentRepo = $this->load( "respondent-repository" );
        $respondentQuestionAnswerRepo = $this->load( "respondent-question-answer-repository" );
        $questionRepo = $this->load( "question-repository" );
        $questionChoiceRepo = $this->load( "question-choice-repository" );
        $prospectPurchaseRepo = $this->load( "prospect-purchase-repository" );
        $accountRepo = $this->load( "account-repository" );
        $userMailer = $this->load( "user-mailer" );
        $userRepo = $this->load( "user-repository" );
        $prospectRepo = $this->load( "prospect-repository" );

        $respondent = $respondentRepo->getByProspectID( $this->prospect->id );

        if ( !is_null( $respondent->id ) ) {
            $questionAnswers = $respondentQuestionAnswerRepo->getAllByRespondentID( $respondent->id );
            foreach ( $questionAnswers as $questionAnswer ) {
                $questionAnswer->question = $questionRepo->getByID( $questionAnswer->question_id );
                $questionAnswer->questionChoice = $questionChoiceRepo->getByID( $questionAnswer->question_choice_id );
            }
            $respondent->questionAnswers = $questionAnswers;
        }

        if ( $input->exists() && $input->issetField( "purchase" ) && $inputValidator->validate(
                $input,
                [
                    "token" => [
                        "equals-hidden" => $this->session->getSession( "csrf-token" ),
                        "required" => true,
                    ],
                    "purchase" => [
                        "required" => true
                    ],
                ],
                "purchase"
            ) )
        {
            // Remove credit from the account for the amount of the prospect's appraisal
            $accountRepo->debitAccountByID( $this->account->id, $this->prospect->appraisal->value );

            // Record a prospect purchase
            $prospectPurchaseRepo->create( $this->business->id, $this->prospect->id );

            // Update requries_purchase to false
            $prospectRepo->updateRequiresPurchaseByID( $this->prospect->id, 0 );

            // Get primary user of this account
            $user = $userRepo->getByID( $this->account->primary_user_id );

            // Send primary user
            $userMailer->sendLeadPurchaseNotification(
                $user->first_name,
                $user->email,
                [
                    "name" => $this->prospect->first_name,
                    "email" => $this->prospect->email,
                    "number" => $this->prospect->phone_number,
                    "id" => $this->prospect->id,
                ]
            );

            $this->view->redirect( "account-manager/business/lead/" . $this->params[ "id" ] . "/" );
        }

        if ( $input->exists() && $input->issetField( "reject" ) && $inputValidator->validate(
                $input,
                [
                    "token" => [
                        "equals-hidden" => $this->session->getSession( "csrf-token" ),
                        "required" => true,
                    ],
                    "reject" => [
                        "required" => true
                    ],
                ],
                "reject_lead"
            ) )
        {
            // Update prospect
            $prospectRepo->updateStatusByID( "rejected", $this->prospect->id );

            // Notify lead was rejected on next page load with flash message
            $this->session->addFlashMessage( "Lead Rejected" );
            $this->session->setFlashMessages();

            // Redirect to leads page
            $this->view->redirect( "account-manager/business/leads" );
        }

        $this->view->assign( "respondent", $respondent );

        $csrf_token = $this->session->generateCSRFToken();
        $this->view->assign( "csrf_token", $csrf_token );

        $this->view->setTemplate( "account-manager/business/lead/purchase.tpl" );
        $this->view->render( "App/Views/AccountManager/Business/Lead.php" );
    }

    public function sequencesAction()
    {
        $input = $this->load( "input" );
        $inputValidator = $this->load( "input-validator" );
        $sequenceTemplateRepo = $this->load( "sequence-template-repository" );
        $businessSequenceRepo = $this->load( "business-sequence-repository" );
        $prospectSequenceRepo = $this->load( "prospect-sequence-repository" );
        $sequenceTemplateSequenceRepo = $this->load( "sequence-template-sequence-repository" );
        $sequenceRepo = $this->load( "sequence-repository" );

        // Get all sequences for this prospect
        $prospectSequences = $prospectSequenceRepo->get( [ "*" ], [ "prospect_id" => $this->prospect->id ] );
        $sequenceTemplates = $sequenceTemplateRepo->get( [ "*" ], [ "business_id" => $this->business->id ] );

        $activeSequenceTemplates = [];
        $active_sequence_template_ids = [];
        $inactiveSequenceTemplates = [];
        $completedSequenceTemplates = [];
        $completed_sequence_template_ids = [];

        // Populate an array ($activeSequenceTemplates) with all sequence templates
        // from which this prospect's sequences were created.
        foreach ( $prospectSequences as $prospectSequence ) {
            $sequence_template_id = $sequenceTemplateSequenceRepo->get( [ "sequence_template_id" ], [ "sequence_id" => $prospectSequence->sequence_id ], "single" )->sequence_template_id;
            $sequenceTemplate = $sequenceTemplateRepo->get( [ "*" ], [ "id" => $sequence_template_id ], "single" );
            $sequenceTemplate->sequence = $sequenceRepo->get( [ "*" ], [ "id" => $prospectSequence->sequence_id ], "single" );

            if ( $sequenceTemplate->sequence->complete ) {
                $completedSequenceTemplates[] = $sequenceTemplate;
                $completed_sequence_template_ids[] = $sequence_template_id;

                continue;
            }

            $activeSequenceTemplates[] = $sequenceTemplate;
            $active_sequence_template_ids[] = $sequence_template_id;
        }

        // Populate an array ($inactiveSequenceTemplates) will all sequence templates
        // that have not been used to generate sequences for this prospect
        foreach ( $sequenceTemplates as $sequenceTemplate ) {
            if (
                !in_array( $sequenceTemplate->id, $active_sequence_template_ids ) &&
                !in_array( $sequenceTemplate->id, $completed_sequence_template_ids )
            ) {
                $inactiveSequenceTemplates[] = $sequenceTemplate;
            }
        }

        if ( $input->exists() && $input->issetField( "add_to_sequence" ) && $inputValidator->validate(
                $input,
                [
                    "token" => [
                        "required" => true,
                        "equals-hidden" => $this->session->getSession( "csrf-token" )
                    ],
                    "sequence_template_id" => [
                        "required" => true,
                        "in_array" => $sequenceTemplateRepo->get( [ "id" ], [ "business_id" => $this->business->id ], "raw" )
                    ],
                    "quantity" => [
                        "numeric" => true
                    ],
                    "unit" => [
                        "in_array" => [ "days", "weeks", "months" ]
                    ]
                ],
                "add_to_sequence"
            )
        ) {
            $sequenceBuilder = $this->load( "sequence-builder" );

            $sequenceBuilder->setRecipientName( $this->prospect->getFullName() )
                ->setSenderName( $this->business->business_name )
                ->setRecipientEmail( $this->prospect->email )
                ->setSenderEmail( $this->business->email )
                ->setRecipientPhoneNumber( $this->phone->getPhoneNumber() )
                ->setSenderPhoneNumber( $this->business->phone->getPhoneNumber() )
                ->setBusinessID( $this->business->id )
                ->setProspectID( $this->params[ "id" ] );

            // Set start time
            if ( $input->issetField( "unit" ) && $input->issetField( "quantity" ) ) {
                $sequenceBuilder->setStartTime(
                    strtotime( "+{$input->get( "quantity" )} {$input->get( "unit" )}" )
                );
            }

            // If a sequence was built successfully, create a prospect and business
            // sequence reference and redirect to the sequence screen
            $sequenceTemplate = $sequenceTemplateRepo->get( [ "*" ], [ "id" => $input->get( "sequence_template_id" ) ], "single" );

            if ( $sequenceBuilder->buildFromSequenceTemplate( $sequenceTemplate->id ) ) {
                $sequence = $sequenceBuilder->getSequence();

                // Inform user of successful sequence creation
                $this->session->addFlashMessage( "{$this->prospect->getFullName()} has been added to sequenece '{$sequenceTemplate->name}'" );
                $this->session->setFlashMessages();

                // Redirect back to the "choose sequence" page
                $this->view->redirect( "account-manager/business/lead/" . $this->params[ "id" ] . "/sequences" );
            }

            // If sequence build fails, get the error messages from the sequence
            // builder and set them to the input validator
            $errorMessages = $sequenceBuilder->getErrorMessages();
            foreach ( $errorMessages as $message ) {
                $inputValidator->addError( "add_to_sequence", $message );
            }

        }

        if ( $input->exists() && $input->issetField( "sequence_id" ) && $inputValidator->validate(
                $input,
                [
                    "token" => [
                        "required" => true,
                        "equals-hidden" => $this->session->getSession( "csrf-token" )
                    ],
                    "sequence_id" => [
                        "required" => true
                    ]
                ],
                "delete_sequence"
            )
        ) {
            $sequenceDestroyer = $this->load( "sequence-destroyer" );
            $eventDestroyer = $this->load( "event-destroyer" );

            $sequenceDestroyer->destroy( $input->get( "sequence_id" ) );
            $eventDestroyer->destroyBySequenceID( $input->get( "sequence_id" ) );

            $this->session->addFlashMessage( "{$this->prospect->getFullName()} successfully removed from sequence." );
            $this->session->setFlashMessages();

            $this->view->redirect( "account-manager/business/lead/" . $this->params[ "id" ] . "/sequences" );
        }

        $this->view->assign( "activeSequenceTemplates", $activeSequenceTemplates );
        $this->view->assign( "inactiveSequenceTemplates", $inactiveSequenceTemplates );
        $this->view->assign( "completedSequenceTemplates", $completedSequenceTemplates );
        $this->view->assign( "csrf_token", $this->session->generateCSRFToken() );
        $this->view->assign( "error_messages", $inputValidator->getErrors() );
        $this->view->assign( "flash_messages", $this->session->getFlashMessages() );

        $this->view->setTemplate( "account-manager/business/lead/sequences.tpl" );
        $this->view->render( "App/Views/AccountManager/Business.php" );
    }
}
