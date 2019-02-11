<?php

namespace Model\Services;

class TaskRepository extends Repository
{

    public function getAllPendingOrderByTriggerTime( $business_id )
    {
        $mapper = $this->getMapper();
        $tasks = $mapper->mapAllOrderByTriggerTime( $business_id, "pending" );

        return $tasks;
    }
}
