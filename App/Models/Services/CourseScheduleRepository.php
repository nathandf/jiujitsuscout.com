<?php

namespace Models\Services;

use Models\CourseSchedule;
use Models\Mappers\CourseScheduleMapper;

class CourseScheduleRepository extends Service
{

    public function create( $course_id, $schedule_id )
    {
        $courseSchedule = new CourseSchedule;
        $courseScheduleMapper = new CourseScheduleMapper( $this->container );
        $courseSchedule->course_id = $course_id;
        $courseSchedule->schedule_id = $schedule_id;
        $courseScheduleMapper->create( $courseSchedule );

        return $courseSchedule;
    }

    public function getByID( $id )
    {
        $courseSchedule = new CourseSchedule();
        $courseScheduleMapper = new CourseScheduleMapper( $this->container );
        $courseScheduleMapper->mapFromID( $courseSchedule, $id );

        return $course;
    }

    public function getAllByCourseID( $course_id )
    {
        $courseScheduleMapper = new \Models\Mappers\CourseScheduleMapper( $this->container );
        $courseSchedules = $courseScheduleMapper->mapAllFromCourseID( $course_id );

        return $courseSchedules;
    }

    public function getAllByScheduleID( $schedule_id )
    {
        $courseScheduleMapper = new \Models\Mappers\CourseScheduleMapper( $this->container );
        $courseSchedules = $courseScheduleMapper->mapAllFromScheduleID( $schedule_id );

        return $courseSchedules;
    }

    public function removeByID( $id )
    {
        $courseScheduleMapper = new \Models\Mappers\CourseScheduleMapper( $this->container );
        $courseScheduleMapper->deleteByID( $id );
    }

    public function removeByScheduleID( $schedule_id )
    {
        $courseScheduleMapper = new \Models\Mappers\CourseScheduleMapper( $this->container );
        $courseScheduleMapper->deleteByScheduleID( $schedule_id );
    }
    
    public function removeByCourseID( $id )
    {
        $courseScheduleMapper = new \Models\Mappers\CourseScheduleMapper( $this->container );
        $courseScheduleMapper->deleteByCourseID( $id );
    }

}
