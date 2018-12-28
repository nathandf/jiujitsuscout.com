<?php

namespace Model\Services;

class TaskRepository extends Repository
{
    public function create( $business_id, $assignee_user_id, $created_by_user_id, $due_date, $title, $message, $status = "pending", $remind_status = 0 )
    {
        $mapper = $this->getMapper();
        $task = $mapper->build( $this->entityName );
        $task->business_id = $business_id;
        $task->assignee_user_id = $assignee_user_id;
        $task->created_by_user_id = $created_by_user_id;
        $task->due_date = $due_date;
        $task->title = $title;
        $task->message = $message;
        $task->status = $status;
        $task->remind_status = $remind_status;
        $mapper->create( $task );

        return $task;
    }

    public function getByID( $id )
    {
        $mapper = $this->getMapper();
        $task = $mapper->build( $this->entityName );
        $mapper->mapFromID( $task, $id );

        return $task;
    }

    public function getAllByBusinessID( $id )
    {
        $mapper = $this->getMapper();
        $tasks = $mapper->mapAllFromBusinessID( $id );

        return $tasks;
    }

    public function getAllByStatus( $status )
    {
        $mapper = $this->getMapper();
        $tasks = $mapper->mapAllFromStatus( $status );

        return $tasks;
    }

    public function updateTitleByID( $id, $title )
    {
        $mapper = $this->getMapper();
        $mapper->updateTitleByID( $id, $title );
    }

    public function updateMessageByID( $id, $message )
    {
        $mapper = $this->getMapper();
        $mapper->updateMessageByID( $id, $message );
    }

    public function updateAssigneeUserIDByID( $id, $user_id )
    {
        $mapper = $this->getMapper();
        $mapper->updateAssigneeUserIDByID( $id, $user_id );
    }

    public function updateStatusByID( $id, $status )
    {
        $mapper = $this->getMapper();
        $mapper->updateStatusByID( $id, $status );
    }

    public function updateDueDateByID( $id, $due_date )
    {
        $mapper = $this->getMapper();
        $mapper->updateDueDateByID( $id, $due_date );
    }

    public function updateRemindStatusByID( $id )
    {
        $mapper = $this->getMapper();
        $mapper->updateRemindStatusByID( $id );
    }

    public function removeByID( $id )
    {
        $mapper = $this->getMapper();
        $mapper->deleteByID( $id );
    }
}
