<?php

namespace Controllers\AccountManager\Business;

use Core\Controller;

class Task extends Controller
{
    private $accountRepo;
    private $account;
    private $businessRepo;
    private $business;
    private $userRepo;
    private $user;

    public function before()
    {
        // Loading services
        $userAuth = $this->load( "user-authenticator" );
        $accountRepo = $this->load( "account-repository" );
        $accountUserRepo = $this->load( "account-user-repository" );
        $businessRepo = $this->load( "business-repository" );
        $userRepo = $this->load( "user-repository" );
        $taskRepo = $this->load( "task-repository" );
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

        // Verify that this business owns this landing page
        $tasks = $taskRepo->get( [ "*" ], [ "business_id" => $this->business->id ] );
        $task_ids = [];
        foreach ( $tasks as $task ) {
            $task_ids[] = $task->id;
        }

        if ( isset( $this->params[ "id" ] ) && !in_array( $this->params[ "id" ], $task_ids ) ) {
            $this->view->redirect( "account-manager/business/tasks/" );
        }

        // Track with facebook pixel
		$Config = $this->load( "config" );
		$facebookPixelBuilder = $this->load( "facebook-pixel-builder" );

		$facebookPixelBuilder->addPixelID( $Config::$configs[ "facebook" ][ "jjs_pixel_id" ] );
		$this->view->assign( "facebook_pixel", $facebookPixelBuilder->build() );

        $this->view->assign( "account", $this->account );
        $this->view->assign( "user", $this->user );
        $this->view->assign( "business", $this->business );
    }

    public function indexAction()
    {
        if ( !$this->issetParam( "id" ) ) {
            $this->view->redirect( "account-manager/business/tasks/" );
        }

        $input = $this->load( "input" );
        $inputValidator = $this->load( "input-validator" );
        $taskRepo = $this->load( "task-repository" );
        $taskTypeRepo = $this->load( "task-type-repository" );
        $taskAssigneeRepo = $this->load( "task-assignee-repository" );
        $userRepo = $this->load( "user-repository" );
        $memberRepo = $this->load( "member-repository" );
        $prospectRepo = $this->load( "prospect-repository" );
        $taskProspectRepo = $this->load( "task-prospect-repository" );
        $taskMemberRepo = $this->load( "task-member-repository" );
        $prospectAppraisalRepo = $this->load( "prospect-appraisal-repository" );
        $prospectPurchaseRepo = $this->load( "prospect-purchase-repository" );
        $phoneRepo = $this->load( "phone-repository" );
        $taskDestroyer = $this->load( "task-destroyer" );

        $task = $taskRepo->get( [ "*" ], [ "id" => $this->params[ "id" ] ], "single" );

        $users = $userRepo->get( [ "*" ], [ "account_id" => $this->account->id ] );
        $user_ids = $userRepo->get( [ "id" ], [ "account_id" => $this->account->id ], "raw" );

        $task_assignee_user_ids = $taskAssigneeRepo->get(
            [ "user_id" ],
            [ "task_id" => $task->id ],
            "raw"
        );

        foreach ( $users as $user ) {
            $user->isset = false;
            if ( in_array( $user->id, $task_assignee_user_ids ) ) {
                $user->isset = true;
            }
        }

        $taskTypes = $taskTypeRepo->get( [ "*" ] );
        $task_type_ids = $taskTypeRepo->get( [ "id" ], [], "raw" );

        $task_ids = $taskRepo->get( [ "id" ], [ "business_id" => $this->business->id ], "raw" );

        $prospectsAll = $prospectRepo->get( [ "*" ], [ "business_id" => $this->business->id ] );
        $prospects = [];
        $task_prospect_prospect_ids = $taskProspectRepo->get( [ "prospect_id" ], [ "task_id" => $task->id ], "raw" );
        foreach ( $prospectsAll as $_prospect ) {
            if ( $_prospect->type != "member" && $_prospect->type != "trash" && !in_array( $_prospect->id, $task_prospect_prospect_ids ) ) {

                // Get the phone object for this person
                $phone = $phoneRepo->get( [ "*" ], [ "id" => $_prospect->phone_id ], "single" );
                if ( !is_null( $phone ) ) {
                    $_prospect->phone_number = !is_null( $phone->national_number ) ? $phone->getNicePhoneNumber() : null;
                }


                // Get appraisal for prospect if one exists
                $appraisal = $prospectAppraisalRepo->get( [ "*" ], [ "prospect_id" => $_prospect->id ], "single" );

                // If prospect doesn't have an appraisal
                if ( is_null( $appraisal ) ) {
                    $prospects[] = $_prospect;

                    continue;
                }

                // Get purchase for prospect if one exists
                $purchase = $prospectPurchaseRepo->get( [ "*" ], [ "prospect_id" => $_prospect->id ], "single" );

                // Don't add this prospect to the list of prospects if it hasn't
                // been purchased
                if ( is_null( $purchase ) ) {
                    continue;
                }

                $prospects[] = $_prospect;
            }
        }

        $membersAll = $memberRepo->get( [ "*" ], [ "business_id" => $this->business->id ] );
        $members = [];
        $task_member_member_ids = $taskMemberRepo->get( [ "member_id" ], [ "task_id" => $task->id ], "raw" );
        foreach ( $membersAll as $_member ) {
            if ( !in_array( $_member->id, $task_member_member_ids ) ) {
                // Get the phone object for this person
                $phone = $phoneRepo->get( [ "*" ], [ "id" => $_member->phone_id ], "single" );
                if ( !is_null( $phone ) ) {
                    $_member->phone_number = !is_null( $phone->national_number ) ? $phone->getNicePhoneNumber() : null;
                }

                $members[] = $_member;
            }
        }

        $taskProspects = $taskProspectRepo->get( [ "*" ], [ "task_id" => $task->id ] );
        foreach ( $taskProspects as $taskProspect ) {
            $taskProspect->prospect = $prospectRepo->get( [ "*" ], [ "id" => $taskProspect->prospect_id ], "single" );
        }

        $taskMembers = $taskMemberRepo->get( [ "*" ], [ "task_id" => $task->id ] );
        foreach ( $taskMembers as $taskMember ) {
            $taskMember->member = $memberRepo->get( [ "*" ], [ "id" => $taskMember->member_id ], "single" );
        }

        if ( $input->exists() && $input->issetField( "add_prospect" ) && $inputValidator->validate(
                $input,
                [
                    "token" => [
                        "equals-hidden" => $this->session->getSession( "csrf-token" ),
                        "required" => true
                    ],
                    "prospect_id" => [
                        "required" => true,
                        "in_array" => $prospectRepo->get( [ "id" ], [ "business_id" => $this->business->id ], "raw" )
                    ]
                ],
                "add_prospect"
            )
        ) {
            $taskProspectRepo->insert([
                "task_id" => $task->id,
                "prospect_id" => $input->get( "prospect_id" )
            ]);

            $this->session->addFlashMessage( "Prospect added to task" );
            $this->session->setFlashMessages();

            $this->view->redirect( "account-manager/business/task/" . $task->id . "/" );
        }

        if ( $input->exists() && $input->issetField( "add_member" ) && $inputValidator->validate(
                $input,
                [
                    "token" => [
                        "equals-hidden" => $this->session->getSession( "csrf-token" ),
                        "required" => true
                    ],
                    "member_id" => [
                        "required" => true,
                        "in_array" => $memberRepo->get( [ "id" ], [ "business_id" => $this->business->id ], "raw" )
                    ]
                ],
                "add_member"
            )
        ) {
            $taskMemberRepo->insert([
                "task_id" => $task->id,
                "member_id" => $input->get( "member_id" )
            ]);

            $this->session->addFlashMessage( "Member added to task" );
            $this->session->setFlashMessages();

            $this->view->redirect( "account-manager/business/task/" . $task->id . "/" );
        }

        if ( $input->exists() && $input->issetField( "reschedule" ) && $inputValidator->validate(
            $input,
            [
                "token" => [
                    "equals-hidden" => $this->session->getSession( "csrf-token" ),
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
            ],
            "reschedule_task" /* error index */
            )
        ) {
            $month = $input->get( "Date_Month" );
            $day = $input->get( "Date_Day" );
            $year = $input->get( "Date_Year" );
            $hour = $input->get( "Time_Hour" );
            $minute = $input->get( "Time_Minute" );
            $meridian = $input->get( "Time_Meridian" );

            // Create unix time stamp for due date
            $due_date_string = $month . "/" . $day . "/" . $year . " " . $hour . ":" . $minute . $meridian;

            // Get timezone offset in seconds
            $timeZoneHelper = $this->load( "time-zone-helper" );
            $timezone_offset = $timeZoneHelper->getServerTimeZoneOffset( $this->business->timezone );

            $trigger_time = strtotime( $due_date_string ) + $timezone_offset;

            $taskRepo->update(
                [
                    "due_date" => $due_date_string,
                    "trigger_time" => $trigger_time
                ],
                [ "id" => $task->id ]
            );

            $this->session->addFlashMessage( "Task Rescheduled" );
            $this->session->setFlashMessages();

            $this->view->redirect( "account-manager/business/task/" . $this->params[ "id" ] . "/" );
        }

        if ( $input->exists() && $input->issetField( "update_task" ) && $inputValidator->validate(
                $input,
                [
                    "token" => [
                        "equals-hidden" => $this->session->getSession( "csrf-token" ),
                        "required" => true
                    ],
                    "update_task" => [
                        "required" => true
                    ],
                    "title" => [
                        "name" => "Task Title",
                        "required" => true,
                        "min" => 1,
                        "max" => 200,
                    ],
                    "message" => [
                        "name" => "Description",
                        "min" => 1,
                        "max" => 1000
                    ],
                    "user_ids" => [
                        "name" => "User ID",
                        "required" => true,
                        "is_array" => true
                    ],
                    "priority" => [
                        "name" => "Priority",
                        "required" => true,
                        "in_array" => [ "low", "medium", "high", "critical" ]
                    ],
                    "task_type_id" => [
                        "required" => true,
                        "in_array" => $task_type_ids
                    ]
                ],
                "update_task" /* error index */
            )
        ) {
            $taskRepo->update(
                [
                    "business_id" => $this->business->id,
                    "task_type_id" => $input->get( "task_type_id" ),
                    "title" => $input->get( "title" ),
                    "message" => $input->get( "message" ),
                    "priority" => $input->get( "priority" ),
                    "created_by_user_id" => $this->user->id
                ],
                [
                    "id" => $task->id
                ]
            );

            // Update TaskAssignees
            $submitted_user_ids = [];
            if ( $input->issetField( "user_ids" ) ) {
                $submitted_user_ids = $input->get( "user_ids" );
            }

            // Create and new task assignee for any of the submitted
            // user ids if it doesn't already exist
            foreach ( $submitted_user_ids as $user_id ) {
                if ( !in_array( $user_id, $task_assignee_user_ids, true ) ) {
                    $taskAssigneeRepo->insert([
                        "task_id" => $task->id,
                        "user_id" => $user_id
                    ]);
                }
            }

            // Delete the task assignees with the user ids that were not
            // submitted if they exist
            foreach ( $user_ids as $_user_id ) {
                if (
                    !in_array( $_user_id, $submitted_user_ids ) &&
                    in_array( $_user_id, $task_assignee_user_ids, true )
                ) {
                    $taskAssigneeRepo->delete( [ "user_id", "task_id" ], [ $_user_id, $task->id ] );
                }
            }

            $this->session->addFlashMessage( "Task Updated" );
            $this->session->setFlashMessages();

            $this->view->redirect( "account-manager/business/task/" . $task->id . "/" );
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
                    "task_id" => [
                        "required" => true,
                        "in_array" => $task_ids
                    ]
                ],

                "delete_task" /* error index */
            ) )
        {
            $taskDestroyer->destroy( $input->get( "task_id" ) );

            // Create flash message
            $this->session->addFlashMessage( "Task Deleted" );
            $this->session->setFlashMessages();

            $this->view->redirect( "account-manager/business/tasks/" );
        }

        if ( $input->exists() && $input->issetField( "remove_prospect" ) && $inputValidator->validate(
                $input,
                [
                    "token" => [
                        "equals-hidden" => $this->session->getSession( "csrf-token" ),
                        "required" => true
                    ],
                    "prospect_id" => [
                        "required" => true,
                        "in_array" => $prospectRepo->get( [ "id" ], [ "business_id" => $this->business->id ], "raw" )
                    ]
                ],
                "remove_prospect"
            )
        ) {
            $taskProspectRepo->delete( [ "task_id","prospect_id" ], [ $task->id, $input->get( "prospect_id" ) ] );

            $this->view->redirect( "account-manager/business/task/" . $task->id . "/" );
        }

        if ( $input->exists() && $input->issetField( "remove_member" ) && $inputValidator->validate(
                $input,
                [
                    "token" => [
                        "equals-hidden" => $this->session->getSession( "csrf-token" ),
                        "required" => true
                    ],
                    "member_id" => [
                        "required" => true,
                        "in_array" => $memberRepo->get( [ "id" ], [ "business_id" => $this->business->id ], "raw" )
                    ]
                ],
                "remove_member"
            )
        ) {
            $taskMemberRepo->delete( [ "task_id","member_id" ], [ $task->id, $input->get( "member_id" ) ] );

            $this->view->redirect( "account-manager/business/task/" . $task->id . "/" );
        }

        $this->view->assign( "task", $task );
        $this->view->assign( "users", $users );
        $this->view->assign( "taskTypes", $taskTypes );
        $this->view->assign( "prospects", $prospects );
        $this->view->assign( "taskProspects", $taskProspects );
        $this->view->assign( "members", $members );
        $this->view->assign( "taskMembers", $taskMembers );

        $this->view->assign( "csrf_token", $this->session->generateCSRFToken() );
        $this->view->setErrorMessages( $inputValidator->getErrors() );
        $this->view->setFlashMessages( $this->session->getFlashMessages( "flash_messages" ) );

        $this->view->setTemplate( "account-manager/business/task/home.tpl" );
        $this->view->render( "App/Views/AccountManager/Business/Task.php" );
    }

    public function newAction()
    {
        if ( $this->issetParam( "id" ) ) {
            $this->view->redirect( "account-manager/business/task/" . $this->params[ "id" ] . "/" );
        }

        $input = $this->load( "input" );
        $inputValidator = $this->load( "input-validator" );
        $taskRepo = $this->load( "task-repository" );
        $taskTypeRepo = $this->load( "task-type-repository" );
        $taskAssigneeRepo = $this->load( "task-assignee-repository" );
        $userRepo = $this->load( "user-repository" );

        $users = $userRepo->get( [ "*" ], [ "account_id" => $this->account->id ] );
        $user_ids = [];

        // Create an array of all user ids verify that the user chosen for the task is a user of this business
        foreach ( $users as $user ) {
            $user_ids[] = $user->id;
        }

        $taskTypes = $taskTypeRepo->get( [ "*" ] );
        $task_type_ids = $taskTypeRepo->get( [ "id" ], [], "raw" );

        if ( $input->exists() && $input->issetField( "create_task" ) && $inputValidator->validate(

                $input,

                [
                    "token" => [
                        "equals-hidden" => $this->session->getSession( "csrf-token" ),
                        "required" => true
                    ],
                    "title" => [
                        "name" => "Task Title",
                        "required" => true,
                        "min" => 1,
                        "max" => 200,
                    ],
                    "message" => [
                        "name" => "Description",
                        "min" => 1,
                        "max" => 1000
                    ],
                    "user_ids" => [
                        "name" => "User ID",
                        "required" => true,
                        "is_array" => true
                    ],
                    "priority" => [
                        "name" => "Priority",
                        "required" => true,
                        "in_array" => [ "low", "medium", "high", "critical" ]
                    ],
                    "task_type_id" => [
                        "required" => true,
                        "in_array" => $task_type_ids
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
                ],

                "create_task" /* error index */
            ) )
        {
            $month = $input->get( "Date_Month" );
            $day = $input->get( "Date_Day" );
            $year = $input->get( "Date_Year" );
            $hour = $input->get( "Time_Hour" );
            $minute = $input->get( "Time_Minute" );
            $meridian = $input->get( "Time_Meridian" );

            // Create unix time stamp for due date
            $due_date_string = $month . "/" . $day . "/" . $year . " " . $hour . ":" . $minute . $meridian;

            // Get timezone offset in seconds
            $timeZoneHelper = $this->load( "time-zone-helper" );
            $timezone_offset = $timeZoneHelper->getServerTimeZoneOffset( $this->business->timezone );

            $trigger_time = strtotime( $due_date_string ) + $timezone_offset;

            $task = $taskRepo->insert([
                "business_id" => $this->business->id,
                "task_type_id" => $input->get( "task_type_id" ),
                "due_date" => $due_date_string,
                "trigger_time" => $trigger_time,
                "title" => $input->get( "title" ),
                "message" => $input->get( "message" ),
                "priority" => $input->get( "priority" ),
                "created_by_user_id" => $this->user->id
            ]);

            $task_assignee_user_ids = [];
            if ( is_array( $input->get( "user_ids" ) ) ) {
                $task_assignee_user_ids = $input->get( "user_ids" );
            }

            foreach ( $task_assignee_user_ids as $user_id ) {
                $taskAssigneeRepo->insert([
                    "task_id" => $task->id,
                    "user_id" => $user_id
                ]);
            }

            $this->view->redirect( "account-manager/business/task/" . $task->id . "/" );
        }

        $inputs = [];

        // update_landing_page
        if ( $input->issetField( "create_task" ) ) {
            $inputs[ "create_task" ][ "title" ] = $input->get( "title" );
            $inputs[ "create_task" ][ "message" ] = $input->get( "message" );
        }

        // Input values submitted from form
        $this->view->assign( "inputs", $inputs );

        $this->view->assign( "current_user", $this->user );
        $this->view->assign( "users", $users );
        $this->view->assign( "taskTypes", $taskTypes );

        $this->view->assign( "csrf_token", $this->session->generateCSRFToken() );
        $this->view->setErrorMessages( $inputValidator->getErrors() );

        $this->view->setTemplate( "account-manager/business/task/new.tpl" );
        $this->view->render( "App/Views/AccountManager/Business/Task.php" );
    }
}
