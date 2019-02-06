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
        $tasks = $taskRepo->getAllByBusinessID( $this->business->id );
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

        $task = $taskRepo->get( [ "*" ], [ "id" => $this->params[ "id" ] ], "single" );

        $users = $userRepo->get( [ "*" ], [ "account_id" => $this->account->id ] );
        $user_ids = [];

        // Create an array of all user ids verify that the user chosen for the task is a user of this business
        foreach ( $users as $user ) {
            $user_ids[] = $user->id;
        }

        $taskTypes = $taskTypeRepo->get( [ "*" ] );
        $task_type_ids = $taskTypeRepo->get( [ "id" ], [], "raw" );

        if ( $input->exists() && $inputValidator->validate(
                $input,
                [
                    "token" => [
                        "equals-hidden" => $this->session->getSession( "csrf-token" ),
                        "required" => true
                    ],
                    "create_task" => [
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

                "update_task" /* error index */
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
            $due_date = strtotime( $due_date_string );

            $taskRepo->update([
                "business_id" => $this->business->id,
                "task_type_id" => $input->get( "task_type_id" ),
                "due_date" => $due_date,
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
            $taskRepo->removeByID( $input->get( "task_id" ) );

            // Create flash message
            $this->session->addFlashMessage( "Task Deleted" );
            $this->session->setFlashMessages();

            $this->view->redirect( "account-manager/business/tasks/" );
        }

        $this->view->assign( "task", $task );
        $this->view->assign( "users", $users );
        $this->view->assign( "taskTypes", $taskTypes );

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

        if ( $input->exists() && $inputValidator->validate(

                $input,

                [
                    "token" => [
                        "equals-hidden" => $this->session->getSession( "csrf-token" ),
                        "required" => true
                    ],
                    "create_task" => [
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
            $due_date = strtotime( $due_date_string );

            $task = $taskRepo->insert([
                "business_id" => $this->business->id,
                "task_type_id" => $input->get( "task_type_id" ),
                "due_date" => $due_date,
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
