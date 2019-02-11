<?php

namespace Model\Mappers;

use Model\Task;

class TaskMapper extends DataMapper
{
    public function mapAllOrderByTriggerTime( $business_id, $status )
    {
        $tasks = [];
        $sql = $this->DB->prepare( "SELECT * FROM task WHERE business_id = :business_id AND status = :status ORDER BY trigger_time ASC" );
        $sql->bindParam( ":business_id", $business_id );
        $sql->bindParam( ":status", $status );
        $sql->execute();

        while ( $resp = $sql->fetch( \PDO::FETCH_ASSOC ) ) {
            $task = $this->entityFactory->build( "Task" );
            $this->populate( $task, $resp );

            $tasks[] = $task;
        }

        return $tasks;
    }
}
