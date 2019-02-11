<?php

namespace Model\Services;

use Model\Schedule;
use Model\Mappers\ScheduleMapper;

class ScheduleRepository extends Repository
{
    public function create( $business_id, $name, $description )
    {
        $mapper = $this->getMapper();
        $schedule = $mapper->build( $this->entityName );
        $schedule->business_id = $business_id;
        $schedule->name = $name;
        $schedule->description = $description;
        $mapper->create( $schedule );

        return $schedule;
    }

    public function getByID( $id )
    {
        $mapper = $this->getMapper();
        $schedule = $mapper->build( $this->entityName );
        $mapper->mapFromID( $schedule, $id );

        return $schedule;
    }

    public function getAllByBusinessID( $business_id )
    {
        $mapper = $this->getMapper();
        $schedules = $mapper->mapAllFromBusinessID( $business_id );

        return $schedules;
    }

    public function updateByID( $schedule_id, $name, $description )
    {
        $mapper = $this->getMapper();
        $mapper->updateByID( $schedule_id, $name, $description );

        return true;
    }

    public function removeByID( $id )
    {
        $mapper = $this->getMapper();
        $mapper->deleteByID( $id );
    }
}
