<?php

namespace Model\Services;

use Model\Services\TaskRepository;
use Model\Services\TaskAssigneeRepo;
use Model\Services\TaskProspectRepository;
use Model\Services\TaskMemberRepository;
use Model\Services\ProspectRepository;
use Model\Services\MemberRepository;
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
* @property Model\Services\TaskProspectRepository
* @property Model\Services\TaskMemberRepository
* @property Model\Services\ProspectRepository
* @property Model\Services\MemberRepository
* @property \Model\Services\UserRepository
* @property \Model\Services\TaskEmailBuilder
* @property \Contracts\MailerInterface
*/

class TaskDispatcher
{
    public function __construct(
        TaskRepository $taskRepo,
        TaskAssigneeRepository $taskAssigneeRepo,
        TaskProspectRepository $taskProspectRepo,
        TaskMemberRepository $taskMemberRepo,
        UserRepository $userRepo,
        ProspectRepository $prospectRepo,
        MemberRepository $memberRepo,
        TaskEmailBuilder $taskEmailBuilder,
        MailerInterface $mailer
    ) {
        $this->taskRepo = $taskRepo;
        $this->taskAssigneeRepo = $taskAssigneeRepo;
        $this->taskProspectRepo = $taskProspectRepo;
        $this->taskMemberRepo = $taskMemberRepo;
        $this->prospectRepo = $prospectRepo;
        $this->memberRepo = $memberRepo;
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
            if ( $task->due_date < time() ) {
                // Check out task so it cannot be dispatched by another concurrent process
                // $this->taskRepo->update( [ "checked_out" => 1 ], [ "id" => $task->id ] );

                // Assign task to task email builder
                $this->taskEmailBuilder->setTask( $task );

                // Get all users associated with this task
                $taskAssignees = $this->taskAssigneeRepo->get( [ "*" ], [ "task_id" => $task->id ] );
                $users = [];
                foreach ( $taskAssignees as $taskAssignee ) {
                    $users[] = $this->userRepo->get( [ "*" ], [ "id" => $taskAssignee->user_id ], "single" );
                }

                // Get all taskProspect and assign them to the taskEmailBuilder
                $taskProspects = $this->taskProspectRepo->get( [ "*" ], [ "task_id" => $task->id ] );
                $prospects = [];
                foreach ( $taskProspects as $taskProspect ) {
                    $prospects[] = $prospect = $this->prospectRepo->get( [ "*" ], [ "id" => $taskProspect->prospect_id ], "single" );
                }
                $this->taskEmailBuilder->addProspects( $prospects );

                // Get all taskProspect and assign them to the taskEmailBuilder
                $taskMembers = $this->taskMemberRepo->get( [ "*" ], [ "task_id" => $task->id ] );
                $members = [];
                foreach ( $taskMembers as $taskMember ) {
                    $members[] = $this->memberRepo->get( [ "*" ], [ "id" => $taskMember->member_id ], "single" );
                }

                $this->taskEmailBuilder->addMembers( $members );

                // Build the email with all provided info
                $this->taskEmailBuilder->build();

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
                        $this->taskEmailBuilder->getBody()
                    );
                    $this->mailer->mail();
                }

                // Update task remind status and check back in
                // $this->taskRepo->update( [ "checked_out" => 0, "remind_status" => 1 ], [ "id" => $task->id ] );
            }
        }
    }
}
