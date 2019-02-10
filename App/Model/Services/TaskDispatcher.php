<?php

namespace Model\Services;

use Model\Services\TaskRepository;
use Model\Services\TaskAssigneeRepo;
use \Model\Services\UserRepository;
use \Model\Services\TaskEmailBuilder;
use Contracts\MailerInterface;

/**
* Class SequenceDispatcher
*
* @package Model\Services
*
* @property \Model\Services\TaskRepository
* @property \Model\Services\TaskAssigneeRepository
* @property \Model\Services\UserRepository
* @property \Model\Services\TaskEmailBuilder
* @property \Contracts\MailerInterface
*/

class TaskDispatcher
{
    public function __construct(
        TaskRepository $taskRepo,
        TaskAssigneeRepository $taskAssigneeRepo,
        UserRepository $userRepo,
        TaskEmailBuilder $taskEmailBuilder,
        MailerInterface $mailer,
    ) {
        $this->taskRepo = $taskRepo;
        $this->TaskAssigneeRepo = $taskAssigneeRepo;
        $this->userRepo = $userRepo;
        $this->taskEmailBuilder = $taskEmailBuilder;
        $this->mailer = $mailer;
    }

    public function dispatch()
    {
        // Get all pending tasks that are not yet checked out and have not had a
        // reminder email sent
        $tasks = $this->taskRepo->get(
            [ "*" ],
            [
                "checked_out" => 0,
                "status" => "pending",
                "remind_status" => 0
            ]
        );

        foreach ( $tasks as $task ) {
            // Check out task so it cannot be dispatched by another concurrent process
            $this->taskRepo->update( [ "checked_out" => 1 ] );

            // Build the email body based on priority and task type id
            $this->taskEmailBuilder->build( $task->priority, $task->task_type_id );

            // Get all users associated with this task
            $taskAssignees = $this->taskAssigneeRepo->get( [ "*" ], [ "task_id" => $task->id ] );
            $users = [];
            foreach ( $taskAssignees as $taskAssignee ) {
                $users[] = $this->userRepo->get( [ "*" ], [ "id" => $taskAssignee->user_id ], "single" );
            }

            // Send reminder email to each user
            foreach ( $users as $user ) {
                $this->mailer->setRecipientName( $user->getFullName() );
                $this->mailer->setRecipientEmailAddress( $user->email );
                $this->mailer->setSenderName( "JiuJitsuScout" );
                $this->mailer->setSenderEmailAddress( "noreply@jiujitsuscout.com" );
                $this->mailer->setContentType( "text/html" );
                $this->mailer->setEmailSubject(
                    $this->taskEmailBuilder->getSubject()
                );
                $this->mailer->setEmailBody(
                    $this->taskEmailBuilder->setBody()
                );
                $this->mailer->mail();
            }

            // Update task remind status and check back in
            $this->taskRepo->update( [ "checked_out" => 0, "remind_status" => 1 ] );
        }
    }
}
