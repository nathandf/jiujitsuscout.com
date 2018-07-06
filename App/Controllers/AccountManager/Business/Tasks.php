<?php

namespace Controllers\AccountManager\Business;

use Core\Controller;

class Tasks extends Controller
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

        $this->view->assign( "account", $this->account );
        $this->view->assign( "user", $this->user );
        $this->view->assign( "business", $this->business );
    }

    public function indexAction()
    {
        $input = $this->load( "input" );
        $inputValidator = $this->load( "input-validator" );
        $taskRepo = $this->load( "task-repository" );
        $userRepo = $this->load( "user-repository" );
        $mailer = $this->load( "mailer" );

        $tasksAll = $taskRepo->getAllByBusinessID( $this->business->id );
        $tasks = [];
        $task_ids = [];

        // Assign users to task according to task->assignee_user_id and task->created_by_user_id
        foreach ( $tasksAll as $task ) {
            if ( $task->status == "pending" ) {
                $assignee_user = $userRepo->getByID( $task->assignee_user_id );
                $created_by_user = $userRepo->getByID( $task->created_by_user_id );
                $task->assignee_user = $assignee_user;
                $task->created_by_user = $created_by_user;
                $tasks[] = $task;
                $task_ids[] = $task->id;
            }
        }

        if ( $input->exists() && $input->issetField( "complete_task" ) && $inputValidator->validate(

                $input,

                [
                    "token" =>  [
                        "equals-hidden" => $this->session->getSession( "csrf-token" ),
                        "required" => true
                    ],
                    "task_id" => [
                        "required" => true,
                        "in_array" => $task_ids
                    ]
                ],

                "complete_task" /* error index */

            ) )
        {
            $taskRepo->updateStatusByID( $input->get( "task_id" ), "complete" );
            $this->view->redirect( "account-manager/business/tasks/" );
        }

        if ( $input->exists() && $input->issetField( "send_reminder" ) && $inputValidator->validate(

                $input,

                [
                    "token" => [
                        "equals-hidden" => $this->session->getSession( "csrf-token" ),
                        "required" => true
                    ],
                    "task_id" => [
                        "in_array" => $task_ids
                    ]
                ],

                "send_reminder"/* error index */
            ) )
        {
            $task = $taskRepo->getByID( $input->get( "task_id" ) );
            $assigneeUser = $userRepo->getByID( $task->assignee_user_id );

            $mailer->setRecipientName( $assigneeUser->first_name );
            $mailer->setRecipientEmailAddress( $assigneeUser->email );
            $mailer->setSenderName( "JiuJitsuScout" );
            $mailer->setSenderEmailAddress( "alerts@jiujitsuscout.com" );
            $mailer->setContentType( "text/html" );
            $mailer->setEmailSubject( "Task Reminder from {$this->user->first_name}" );
            $mailer->setEmailBody( "
                <b>Task:</b>
                <p>{$task->title}</p>
                <b style='margin-top: 15px'>Description:</b>
                <p>{$task->message}</p>
                <b style='margin-top: 15px'>Task Due Date:</b>
                <p>" . date( "l, M jS Y h:ia", $task->due_date ) . "</p>
                <b style='margin-top: 15px'>Sent By:</b>
                <p>{$this->user->first_name} {$this->user->last_name}</p>
            " );
            $mailer->mail();

            // Create flash message
            $this->session->addFlashMessage( "Reminder email sent" );
            $this->session->setFlashMessages();

            // Redirect to tasks home
            $this->view->redirect( "account-manager/business/tasks/" );
        }

        $this->view->assign( "tasks", $tasks );

        $this->view->assign( "csrf_token", $this->session->generateCSRFToken() );
        $this->view->setErrorMessages( $inputValidator->getErrors() );
        $this->view->setFlashMessages( $this->session->getFlashMessages( "flash_messages" ) );

        $this->view->setTemplate( "account-manager/business/tasks/home.tpl" );
        $this->view->render( "App/Views/AccountManager/Business/Tasks.php" );
    }

}
