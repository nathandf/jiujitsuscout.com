<?php

namespace Model\Services;

class TaskRepository extends Service
{

    public function create( $business_id, $assignee_user_id, $created_by_user_id, $due_date, $title, $message, $status = "pending", $remind_status = 0 )
    {
        $task = new \Model\Task();
        $taskMapper = new \Model\Mappers\TaskMapper( $this->container );
        $task->business_id = $business_id;
        $task->assignee_user_id = $assignee_user_id;
        $task->created_by_user_id = $created_by_user_id;
        $task->due_date = $due_date;
        $task->title = $title;
        $task->message = $message;
        $task->status = $status;
        $task->remind_status = $remind_status;
        $taskMapper->create( $task );

        return $task;
    }

    public function getByID( $id )
    {
        $task = new \Model\Task();
        $taskMapper = new \Model\Mappers\TaskMapper( $this->container );
        $taskMapper->mapFromID( $task, $id );

        return $task;
    }

    public function getAllByBusinessID( $id )
    {
        $taskMapper = new \Model\Mappers\TaskMapper( $this->container );
        $tasks = $taskMapper->mapAllFromBusinessID( $id );

        return $tasks;
    }

    public function getAllByStatus( $status )
    {
        $taskMapper = new \Model\Mappers\TaskMapper( $this->container );
        $tasks = $taskMapper->mapAllFromStatus( $status );

        return $tasks;
    }

    public function updateTitleByID( $id, $title )
    {
        $taskMapper = new \Model\Mappers\TaskMapper( $this->container );
        $taskMapper->updateTitleByID( $id, $title );
    }

    public function updateMessageByID( $id, $message )
    {
        $taskMapper = new \Model\Mappers\TaskMapper( $this->container );
        $taskMapper->updateMessageByID( $id, $message );
    }

    public function updateAssigneeUserIDByID( $id, $user_id )
    {
        $taskMapper = new \Model\Mappers\TaskMapper( $this->container );
        $taskMapper->updateAssigneeUserIDByID( $id, $user_id );
    }

    public function updateStatusByID( $id, $status )
    {
        $taskMapper = new \Model\Mappers\TaskMapper( $this->container );
        $taskMapper->updateStatusByID( $id, $status );
    }

    public function updateDueDateByID( $id, $due_date )
    {
        $taskMapper = new \Model\Mappers\TaskMapper( $this->container );
        $taskMapper->updateDueDateByID( $id, $due_date );
    }

    public function updateRemindStatusByID( $id )
    {
        $taskMapper = new \Model\Mappers\TaskMapper( $this->container );
        $taskMapper->updateRemindStatusByID( $id );
    }

    public function removeByID( $id )
    {
        $taskMapper = new \Model\Mappers\TaskMapper( $this->container );
        $taskMapper->deleteByID( $id );
    }

}
