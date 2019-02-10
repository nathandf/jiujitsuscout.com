<?php

namespace Model\Services;

use \Model\Services\TaskRepository;
use \Model\Services\TaskAssigneeRepository;
use \Model\Services\TaskProspectRepository;
use \Model\Services\TaskMemberRepository;
use \Model\Services\TaskCommentRepository;

/**
* Class TaskDestroyer
*
* @package Model\Services
*
* @property \Model\Services\TaskRepository
* @property \Model\Services\TaskAssigneeRepository
* @property \Model\Services\TaskProspectRepository
* @property \Model\Services\TaskMemberRepository
* @property \Model\Services\TaskCommentRepository
*/

class TaskDestroyer
{
    public function __construct(
        TaskRepository $taskRepo,
        TaskAssigneeRepository $taskAssigneeRepo,
        TaskProspectRepository $taskProspectRepo,
        TaskMemberRepository $taskMemberRepo,
        TaskCommentRepository $taskCommentRepo
    ) {
        $this->taskRepo = $taskRepo;
        $this->taskAssigneeRepo = $taskAssigneeRepo;
        $this->taskProspectRepo = $taskProspectRepo;
        $this->taskMemberRepo = $taskMemberRepo;
        $this->taskCommentRepo = $taskCommentRepo;
    }

    public function destroy( $task_id )
    {
        $this->taskRepo->delete( [ "id" ], [ $task_id ] );
        $this->taskAssigneeRepo->delete( [ "task_id" ], [ $task_id ] );
        $this->taskProspectRepo->delete( [ "task_id" ], [ $task_id ] );
        $this->taskMemberRepo->delete( [ "task_id" ], [ $task_id ] );
        $this->taskCommentRepo->delete( [ "task_id" ], [ $task_id ] );
    }
}
