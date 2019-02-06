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
        $accountUser = $accountUserRepo->get( [ "*" ], [ "user_id" => $this->user->id ], "single" );
        // Grab account details
        $this->account = $accountRepo->get( [ "*" ], [ "id" => $accountUser->account_id ], "single" );
        // Grab business details
        $this->business = $businessRepo->getByID( $this->user->getCurrentBusinessID() );

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
        $input = $this->load( "input" );
        $inputValidator = $this->load( "input-validator" );
        $taskRepo = $this->load( "task-repository" );
        $userRepo = $this->load( "user-repository" );
        $mailer = $this->load( "mailer" );
        $taskTypeRepo = $this->load( "task-type-repository" );
        $taskAssigneeRepo = $this->load( "task-assignee-repository" );
        $taskCommentRepo = $this->load( "task-comment-repository" );

        $tasks = $taskRepo->get( [ "*" ], [ "business_id" => $this->business->id, "status" => "pending" ] );
        $task_ids = $taskRepo->get( [ "id" ], [ "business_id" => $this->business->id, "status" => "pending" ], "raw" );

        foreach ( $tasks as $task ) {
            $task->assignees = $taskAssigneeRepo->get(  [ "*" ], [ "task_id" => $task->id ]  );
            foreach ( $task->assignees as $assignee ) {
                $assignee->user = $userRepo->get( [ "*" ], [ "id" => $assignee->user_id ], "single" );
            }

            $task->comments = $taskCommentRepo->get( [ "*" ], [ "task_id" => $task->id ] );
            foreach ( $task->comments as $comment ) {
                $comment->commenter = $userRepo->get( [ "*" ], [ "id" => $comment->user_id ], "single" );
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
            )
        ) {
            $taskRepo->update( [ "status" => "complete" ], [ "id" => $input->get( "task_id" ) ] );
            $this->view->redirect( "account-manager/business/tasks/" );
        }

        if ( $input->exists() && $input->issetField( "comment" ) && $inputValidator->validate(
                $input,
                [
                    "token" =>  [
                        "equals-hidden" => $this->session->getSession( "csrf-token" ),
                        "required" => true
                    ],
                    "task_id" => [
                        "required" => true,
                        "in_array" => $task_ids
                    ],
                    "comment" => [
                        "required" => true
                    ]
                ],
                "complete_task" /* error index */
            )
        ) {
            $timeZoneHelper = $this->load( "time-zone-helper" );

            $created_at = time() - $timeZoneHelper->getServerTimeZoneOffset( $this->business->timezone );

            $taskComment = $taskCommentRepo->insert([
                "task_id" => $input->get( "task_id" ),
                "body" => $input->get( "comment" ),
                "created_at" => $created_at,
                "user_id" => $this->user->id
            ]);

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
            )
        ) {
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
