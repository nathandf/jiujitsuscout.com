<?php

namespace Controllers\AccountManager;

use Core\Controller;

class Business extends Controller
{
    private $businesses = [];
    private $business;
    private $account;
    private $user;

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
        $accountUser = $accountUserRepo->getByUserID( $this->user->id );
        // Grab account details
        $this->account = $accountRepo->getByID( $accountUser->account_id );
        // Get account type details
        $this->account_type = $accountTypeRepo->getByID( $this->account->account_type_id );
        // Grab business details
        $this->business = $businessRepo->getByID( $this->user->getCurrentBusinessID() );

        // Set data for the view
        $this->view->assign( "account_type", $this->account_type );
        $this->view->assign( "account", $this->account );
        $this->view->assign( "user", $this->user );
        $this->view->assign( "business", $this->business );
    }

    public function indexAction()
    {
        // Load services
        $prospectRepo = $this->load( "prospect-repository" );
        $memberRepo = $this->load( "member-repository" );
        $appointmentRepo = $this->load( "appointment-repository" );

        // Get pending leads and leads on trial
        $leads = $prospectRepo->getAllByStatusAndBusinessID( "pending", $this->business->id );
        $trials = $prospectRepo->getAllByTypeAndBusinessID( "trial", $this->business->id );

        // Load members
        $members = $memberRepo->getAllByBusinessID( $this->business->id );

        // Load appointments
        $appointments = [];
        $appointmentsAll = $appointmentRepo->getAllByBusinessID( $this->business->id );
        foreach ( $appointmentsAll as $appointment ) {
            if ( $appointment->status == "pending" ) {
                $appointments[] = $appointment;
            }
        }

        $this->view->assign( "leads", $leads );
        $this->view->assign( "appointments", $appointments );
        $this->view->assign( "trials", $trials );
        $this->view->assign( "members", $members );

        $this->view->setTemplate( "account-manager/business/home.tpl" );
        $this->view->render( "App/Views/AccountManager/Business.php" );
    }

    public function appointmentsAction()
    {
        $input = $this->load( "input" );
        $prospectRepo = $this->load( "prospect-repository" );
        $timeManager = $this->load( "time-manager" );
        // Load appointments
        $appointmentRepo = $this->load( "appointment-repository" );
        $appointments = $appointmentRepo->getAllByBusinessID( $this->business->id );

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
                $appointment->prospect = $prospectRepo->getByID( $appointment->prospect_id );
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

        $this->view->setTemplate( "account-manager/business/appointments.tpl" );
        $this->view->render( "App/Views/AccountManager/Business.php" );
    }

    public function leadsAction()
    {
        $input = $this->load( "input" );
        $inputValidator = $this->load( "input-validator" );
        $prospectRepo = $this->load( "prospect-repository" );
        $memberRegistrar = $this->load( "member-registrar" );
        $phoneRepo = $this->load( "phone-repository" );
        $groupRepo = $this->load( "group-repository" );
        $factory = $this->load( "entity-factory" );
        $appointmentRepo = $this->load( "appointment-repository" );

        // Get all leads and trials
        $leadsAll = $prospectRepo->getAllByStatusAndBusinessID( "pending", $this->business->id );
        $lead_ids = [];
        $leads = [];
        $trials = [];

        // Seperate leads by status (lead and trial), load phone resource, and set phone number
        foreach ( $leadsAll as $lead ) {

            // Get phone resources for all leads and trials and assign them to their respective owners
            $phone = $phoneRepo->getByID( $lead->phone_id );
            $lead->setPhoneNumber( $phone->country_code, $phone->national_number );

            // Seperate into trials and leads
            if ( $lead->type == "lead" ) {
                $leads[] = $lead;
            } elseif ( $lead->type == "trial" ) {
                $trials[] = $lead;
            }

            // Create rray of all lead's ids
            $lead_ids[] = $lead->id;
        }

        // Load all groups by business_id to an array
        $groups = $groupRepo->getAllByBusinessID( $this->business->id );

        // Filtering leads
        if ( $input->exists( "get" ) && $input->issetField( "limit" ) ) {
            if ( is_numeric( $input->get( "limit" ) ) ) {
                $leads = array_slice( $leads, 0, $input->get( "limit" ) );
            }
        } else {
            $leads = array_slice( $leads, 0, 25 );
        }
        // Bulk action updating for leads
        if ( $input->exists() && $inputValidator->validate( $input,
                [
                    "token" => [
                        "required" => true,
                        "equals-hidden" => $this->session->getSession( "csrf-token" )
                    ],
                    "update_leads" => [
                        "required" => true
                    ],
                    "action" => [
                        "required" => true
                    ],
                    "lead_ids" => [
                        "name" => "At least one checkbox",
                        "required" => true
                    ]
                ], "update_leads" // error index
            ) )
        {
            if ( $input->issetField( "lead_ids" ) ) {
                if ( is_array( $input->get( "lead_ids" ) ) ) {
                    $lead_count = count( $input->get( "lead_ids" ) );
                    $iteration = 0;
                    foreach ( $input->get( "lead_ids" ) as $lead_id ) {
                        // Check the id of the lead being updated/deleted. Skip if not owned by this business
                        if ( in_array( $lead_id, $lead_ids ) ) {
                            $iteration++;
                            // Convert lead_id to integer. Will come from POST array as string
                            $lead_id = intval( $lead_id );
                            $prospect = $prospectRepo->getByID( $lead_id );
                            switch ( $input->get( "action" ) ) {
                                case "member":
                                    // build empty Member object
                                    $member = $factory->build( "Member" );
                                    $member->business_id = $this->business->id;
                                    $member->phone_id = $prospect->phone_id;
                                    // Register prospect as member
                                    $member = $memberRegistrar->registerProspect( $member, $prospect );
                                    $prospectRepo->updateTypeByID( "member", $prospect->id );
                                    $prospectRepo->updateStatusByID( "member", $prospect->id );
                                    if ( $iteration == $lead_count ) {
                                        $this->session->addFlashMessage( "Leads converted to members ($lead_count)" );
                                    }
                                    break;
                                case "trash":
                                    // Change the status to trash.
                                    $prospectRepo->updateStatusByID( "trash", $lead_id );
                                    $prospectRepo->updateTypeByID( "trash", $lead_id );
                                    // Remove group ids
                                    $prospectRepo->updateGroupIDsByID( "", $lead_id );
                                    // Remove appointments assosciated with lead
                                    $appointmentRepo->removeByProspectID( $lead_id );
                                    if ( $iteration == $lead_count ) {
                                        $this->session->addFlashMessage( "Leads trashed ($lead_count)" );
                                    }
                                    break;
                                case "contacted":
                                    // Break if prospect is already contacted
                                    if ( $prospect->times_contacted < 1 ) {
                                        $prospectRepo->updateTimesContactedByID( 1, $lead_id );
                                    }
                                    // Set flash message
                                    if ( $iteration == $lead_count ) {
                                        $this->session->addFlashMessage( "Leads marked as contacted ($lead_count)" );
                                    }
                                    break;
                                case "uncontacted":
                                    // Change status back to pending and remove all times contacted
                                    $prospectRepo->updateStatusByID( "pending", $lead_id );
                                    $prospectRepo->updateTimesContactedByID( 0, $lead_id );
                                    // Set flash message
                                    if ( $iteration == $lead_count ) {
                                        $this->session->addFlashMessage( "Leads marked as uncontacted ($lead_count)" );
                                    }
                                    break;
                                case ( preg_match( "/group-[ 0-9 ]+/", $input->get( "action" ) ) ? true : false ):
                                    // Using regex to see if action == group, a hyphen, and any combination of numbers
                                    $group_id = intval( str_replace( "group-", "", $input->get( "action" ) ) );
                                    $current_groups = explode( ",", $prospect->group_ids );
                                    if ( !in_array( $group_id, $current_groups ) ) {
                                        $current_groups[] = $group_id;
                                        $prospectRepo->updateGroupIDsByID( implode( ",", $current_groups ), $prospect->id );
                                    }
                                    // Get group
                                    $group = $groupRepo->getByID( $group_id );
                                    // Set flash message
                                    if ( $iteration == $lead_count ) {
                                        $this->session->addFlashMessage( "Leads added to '{$group->name}' group ($lead_count)" );
                                    }
                                    break;
                            }
                        }
                    }
                }
            }

            $this->session->setFlashMessages();

            $this->view->redirect( "account-manager/business/leads" );
        }

        $this->view->assign( "csrf_token", $this->session->generateCSRFToken() );
        $this->view->setErrorMessages( $inputValidator->getErrors() );
        $this->view->setFlashMessages( $this->session->getFlashMessages( "flash_messages" ) );

        $this->view->assign( "groups", $groups );
        $this->view->assign( "leads", $leadsAll );

        $this->view->setTemplate( "account-manager/business/leads.tpl" );
        $this->view->render( "App/Views/AccountManager/Business.php" );
    }

    public function addLeadAction()
    {
        $input = $this->load( "input" );
        $inputValidator = $this->load( "input-validator" );
        $phoneRepo = $this->load( "phone-repository" );
        $prospectRepo = $this->load( "prospect-repository" );
        $groupRepo = $this->load( "group-repository" );
        $entityFactory = $this->load( "entity-factory" );
        $countryRepo = $this->load( "country-repository" );

        // Get all coutnry data
        $countries = $countryRepo->getAll();

        // Set current coutnry
        $country = $countryRepo->getByISO( $this->account->country );

        // Groups and group IDs
        $groups = $groupRepo->getAllByBusinessID( $this->business->id );
        $group_ids = [];

        foreach ( $groups as $group ) {
            $group_ids[] = $group->id;
        }

        // Add lead
        if ( $input->exists() && $inputValidator->validate( $input,
                [
                    "token" => [
                        "equals-hidden" => $this->session->getSession( "csrf-token" ),
                        "required" => true
                    ],
                    "first_name" => [
                        "name" => "First Name",
                        "required" => true
                    ],
                    "email" => [
                        "name" => "Email",
                        "email" => true
                    ],
                    "country_code" => [
                        "name" => "Country Code",
                        "min" => 1,
                        "max" => 10
                    ],
                    "number" => [
                        "name" => "Phone Number",
                        "phone" => true
                    ],
                    "source" => [
                        "name" => "Source"
                    ],
                    "group_ids" => [
                        "name" => "Group IDs",
                        "is_array" => true
                    ]
                ],

                "add_lead" // error index
            ) )
        {
            // Build phone
            $phone = $phoneRepo->create( $input->get( "country_code" ), $input->get( "number" ) );

            $prospect = $entityFactory->build( "Prospect" );
            $prospect->setFirstName( $input->get( "first_name" ) );
            $prospect->setLastName( $input->get( "last_name" ) );
            $prospect->setEmail( $input->get( "email" ) );
            $prospect->business_id = $this->business->id;
            $prospect->source = $input->get( "source" );
            $prospect->phone_id = $phone->id;
            $prospect_id = $prospectRepo->save( $prospect );

            if ( $input->issetField( "group_ids" ) && !empty( $input->get( "group_ids" ) ) ) {
                $submitted_group_ids = $input->get( "group_ids" );
                foreach ( $submitted_group_ids as $key => $submitted_group_id ) {
                    // Verify that the all submitted group ids are owned by this business. If not, unset.
                    if ( !in_array( $submitted_group_id, $group_ids ) ) {
                        unset( $submitted_group_ids[ $key ] );
                    }
                }

                $prospectRepo->updateGroupIDsByID( implode( ",", $submitted_group_ids ), $prospect_id );
            }

            if ( $input->issetField( "schedule_appointment" ) && $input->get( "schedule_appointment" ) == "true" ) {
                $this->view->redirect( "account-manager/business/appointment/schedule?prospect_id=" . $prospect_id );
            }
            
            $this->view->redirect( "account-manager/business/lead/" . $prospect_id . "/" );
        }

        $inputs = [];

        // add_lead
        if ( $input->issetField( "add_lead" ) ) {
            $inputs[ "add_lead" ][ "first_name" ] = $input->get( "first_name" );
            $inputs[ "add_lead" ][ "last_name" ] = $input->get( "last_name" );
            $inputs[ "add_lead" ][ "email" ] = $input->get( "email" );
            $inputs[ "add_lead" ][ "number" ] = $input->get( "number" );
        }

        // Input values submitted from form
        $this->view->assign( "inputs", $inputs );

        $this->view->assign( "groups", $groups );
        $this->view->assign( "countries", $countries );
        $this->view->assign( "country_code", $country->phonecode );

        $csrf_token = $this->session->generateCSRFToken();
        $this->view->assign( "csrf_token", $csrf_token );
        $this->view->setErrorMessages( $inputValidator->getErrors() );

        $this->view->setFlashMessages( $this->session->getFlashMessages( "flash_messages" ) );

        $this->view->setTemplate( "account-manager/business/lead/add-lead.tpl" );
        $this->view->render( "App/Views/AccountManager/Business/Lead.php" );
    }

    public function membersAction()
    {
        // Load members
        $memberRepo = $this->load( "member-repository" );
        $members = $memberRepo->getAllByBusinessID( $this->business->id );
        $phoneRepo = $this->load( "phone-repository" );

        foreach ( $members as $member ) {
            $phone = $phoneRepo->getByID( $member->phone_id );
            $member->setPhoneNumber( $phone->country_code, $phone->national_number );
        }

        $this->view->assign( "members", $members );

        $this->view->setTemplate( "account-manager/business/members.tpl" );
        $this->view->render( "App/Views/AccountManager/Business.php" );
    }

    public function trialsAction()
    {
        // Load prospects by type associated with business
        $prospectRepo = $this->load( "prospect-repository" );
        $prospects = $prospectRepo->getAllByStatusAndBusinessID( "pending", $this->business->id );

        $trials = [];
        foreach ( $prospects as $prospect ) {
            if ( $prospect->type == "trial" ) {
                $trials[] = $prospect;
            }
        }

        $this->view->assign( "trials", $trials );

        $trials_by_time = [];
        $trials_by_time[ "today" ] = [];
        $trials_by_time[ "tomorrow" ] = [];
        $trials_by_time[ "past" ] = [];
        $trials_by_time[ "this_week" ] = [];
        $trials_by_time[ "next_week" ] = [];
        $trials_by_time[ "upcoming" ] = [];
        $timeManager = $this->load( "time-manager" );

        foreach ( $trials as $trial ) {
            if ( $timeManager->isToday( $trial->trial_end ) ) {
                $trials_by_time[ "today" ][] = $trial;
            } elseif ( $timeManager->isTomorrow( $trial->trial_end ) ) {
                $trials_by_time[ "tomorrow" ][] = $trial;
            } elseif ( $timeManager->isPast( $trial->trial_end ) ) {
                $trials_by_time[ "past" ][] = $trial;
            } elseif ( $timeManager->isThisWeek( $trial->trial_end ) ) {
                $trials_by_time[ "this_week" ][] = $trial;
            } elseif ( $timeManager->isNextWeek( $trial->trial_end ) ) {
                $trials_by_time[ "next_week" ][] = $trial;
            } elseif ( $timeManager->isFuture( $trial->trial_end ) ) {
                $trials_by_time[ "upcoming" ][] = $trial;
            }
        }

        $this->view->assign( "trials_by_time", $trials_by_time );
        $this->view->setTemplate( "account-manager/business/trials.tpl" );
        $this->view->render( "App/Views/AccountManager/Business.php" );
    }

}
