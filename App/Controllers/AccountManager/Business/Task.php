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
        $userRepo = $this->load( "user-repository" );

        $tasksAll = $taskRepo->getAllByBusinessID( $this->business->id );
        $task_ids = [];

        foreach ( $tasksAll as $task ) {
            $task_ids[] = $task->id;
        }

        // Set task from query string param
        $task = $taskRepo->getByID( $this->params[ "id" ] );

        // Set current selected date and time values as default
        $month = date( "m", $task->due_date );
        $day = date( "d", $task->due_date );
        $year = date( "Y", $task->due_date );

        $hour = date( "H", $task->due_date );
        $minute = date( "i", $task->due_date );

        // Assign date and time values to view
        $this->view->assign( "month", $month );
        $this->view->assign( "day", $day );
        $this->view->assign( "year", $year );
        $this->view->assign( "hour", $hour );
        $this->view->assign( "minute", $minute );

        // Load user assigned to this task
        $task->assignee_user = $userRepo->getByID( $task->assignee_user_id );

        // Load All users
        $users = $userRepo->getAllByAccountID( $this->account->id );
        $user_ids = [];

        // Create an array of all user ids verify that the user chosen for the task is a user of this business
        foreach ( $users as $user ) {
            $user_ids[] = $user->id;
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
                        "name" => "Task Name",
                        "required" => true,
                        "min" => 1,
                        "max" => 200,
                    ],
                    "message" => [
                        "name" => "Description",
                        "min" => 1,
                        "max" => 1000
                    ],
                    "user_id" => [
                        "name" => "User ID",
                        "required" => true,
                        "in_array" => $user_ids
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

            // Update User ID
            $taskRepo->updateAssigneeUserIDByID( $this->params[ "id" ], $input->get( "user_id" ) );

            // Update Due Date
            $taskRepo->updateDueDateByID( $this->params[ "id" ], $due_date );

            // Update Title
            $taskRepo->updateTitleByID( $this->params[ "id" ], $input->get( "title" ) );

            // Update Message(Description)
            $taskRepo->updateMessageByID( $this->params[ "id" ], $input->get( "message" ) );

            // Update status to pending
            $taskRepo->updateStatusByID( $this->params[ "id" ], "pending" );

            // Create flash message
            $this->session->addFlashMessage( "Task Updated" );
            $this->session->setFlashMessages();

            $this->view->redirect( "account-manager/business/task/" . $this->params[ "id" ] . "/" );
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
        $userRepo = $this->load( "user-repository" );

        $users = $userRepo->getAllByAccountID( $this->account->id );
        $user_ids = [];

        // Create an array of all user ids verify that the user chosen for the task is a user of this business
        foreach ( $users as $user ) {
            $user_ids[] = $user->id;
        }

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
                    "user_id" => [
                        "name" => "User ID",
                        "required" => true,
                        "in_array" => $user_ids
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

            $task = $taskRepo->create( $this->business->id, $input->get( "user_id" ), $this->user->id, $due_date, $input->get( "title" ), $input->get( "message" ) );
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

        $this->view->assign( "csrf_token", $this->session->generateCSRFToken() );
        $this->view->setErrorMessages( $inputValidator->getErrors() );

        $this->view->setTemplate( "account-manager/business/task/new.tpl" );
        $this->view->render( "App/Views/AccountManager/Business/Task.php" );
    }
}
