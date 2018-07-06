<?php

namespace Models\Mappers;

use Models\Task;

class TaskMapper extends DataMapper
{

    public function create( \Models\Task $task )
    {
        $id = $this->insert(
            "task",
            [ "business_id", "assignee_user_id", "created_by_user_id", "due_date", "title", "message", "remind_status", "status" ],
            [ $task->business_id, $task->assignee_user_id, $task->created_by_user_id, $task->due_date, $task->title, $task->message, $task->remind_status, $task->status ]
        );
        $task->id = $id;

        return $task;
    }

    public function mapFromID( Task $task, $id )
    {
        $sql = $this->DB->prepare( "SELECT * FROM task WHERE id = :id" );
        $sql->bindParam( ":id", $id );
        $sql->execute();
        $resp = $sql->fetch( \PDO::FETCH_ASSOC );
        $this->populateTask( $task, $resp );

        return $task;
    }

    public function mapAllFromBusinessID( $business_id )
    {
        $entityFactory = $this->container->getService( "entity-factory" );
        $tasks = [];
        $sql = $this->DB->prepare( "SELECT * FROM task WHERE business_id = :business_id ORDER BY due_date DESC" );
        $sql->bindParam( ":business_id", $business_id );
        $sql->execute();
        while ( $resp = $sql->fetch( \PDO::FETCH_ASSOC ) ) {
            $task = $entityFactory->build( "Task" );
            $this->populateTask( $task, $resp );

            $tasks[] = $task;
        }

        return $tasks;
    }

    public function mapAllFromStatus( $status )
    {
        $entityFactory = $this->container->getService( "entity-factory" );
        $tasks = [];
        $sql = $this->DB->prepare( "SELECT * FROM task WHERE status = :status ORDER BY due_date DESC" );
        $sql->bindParam( ":status", $status );
        $sql->execute();
        while ( $resp = $sql->fetch( \PDO::FETCH_ASSOC ) ) {
            $task = $entityFactory->build( "Task" );
            $this->populateTask( $task, $resp );

            $tasks[] = $task;
        }

        return $tasks;
    }

    public function updateTitleByID( $id, $title )
    {
        $this->update( "task", "title", $title, "id", $id );
    }

    public function updateMessageByID( $id, $message )
    {
        $this->update( "task", "message", $message, "id", $id );
    }

    public function updateAssigneeUserIDByID( $id, $assignee_user_id )
    {
        $this->update( "task", "assignee_user_id", $assignee_user_id, "id", $id );
    }

    public function updateStatusByID( $id, $status )
    {
        $this->update( "task", "status", $status, "id", $id );
    }

    public function updateDueDateByID( $id, $due_date )
    {
        $this->update( "task", "due_date", $due_date, "id", $id );
    }

    public function updateRemindStatusByID( $id )
    {
        $remind_status = 1;

        $this->update( "task", "remind_status", $remind_status, "id", $id );
    }

    public function deleteByID( $id )
    {
        $sql = $this->DB->prepare( "DELETE FROM task WHERE id = :id" );
        $sql->bindParam( ":id", $id );
        $sql->execute();
    }

    public function populateTask( $task, $data )
    {
        $task->id                          = $data[ "id" ];
        $task->business_id                 = $data[ "business_id" ];
        $task->assignee_user_id            = $data[ "assignee_user_id" ];
        $task->created_by_user_id          = $data[ "created_by_user_id" ];
        $task->due_date                    = $data[ "due_date" ];
        $task->title                       = $data[ "title" ];
        $task->message                     = $data[ "message" ];
        $task->remind_status               = $data[ "remind_status" ];
        $task->status                      = $data[ "status" ];
    }

}
