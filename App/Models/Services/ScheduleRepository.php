<?php

namespace Models\Services;

use Models\Schedule;
use Models\Mappers\ScheduleMapper;

class ScheduleRepository extends Service
{

    public function create( $business_id, $name, $description )
    {
        $schedule = new Schedule();
        $scheduleMapper = new ScheduleMapper( $this->container );
        $schedule->business_id = $business_id;
        $schedule->name = $name;
        $schedule->description = $description;
        $scheduleMapper->create( $schedule );

        return $schedule;
    }

    public function getByID( $id )
    {
        $schedule = new Schedule();
        $scheduleMapper = new ScheduleMapper( $this->container );
        $scheduleMapper->mapFromID( $schedule, $id );

        return $schedule;
    }

    public function getAllByBusinessID( $business_id )
    {
        $scheduleMapper = new \Models\Mappers\ScheduleMapper( $this->container );
        $schedules = $scheduleMapper->mapAllFromBusinessID( $business_id );

        return $schedules;
    }

    public function updateByID( $schedule_id, $name, $description )
    {
        $scheduleMapper = new \Models\Mappers\ScheduleMapper( $this->container );
        $scheduleMapper->updateByID( $schedule_id, $name, $description );

        return true;
    }

    public function removeByID( $id )
    {
        $scheduleMapper = new \Models\Mappers\ScheduleMapper( $this->container );
        $scheduleMapper->deleteByID( $id );
    }

}
