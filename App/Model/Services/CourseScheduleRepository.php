<?php

namespace Model\Services;

use Model\CourseSchedule;
use Model\Mappers\CourseScheduleMapper;

class CourseScheduleRepository extends Repository
{

    public function create( $course_id, $schedule_id )
    {
        $mapper = $this->getMapper();
        $courseSchedule = $mapper->build( $this->entityName );
        $courseSchedule->course_id = $course_id;
        $courseSchedule->schedule_id = $schedule_id;
        $mapper->create( $courseSchedule );

        return $courseSchedule;
    }

    public function getByID( $id )
    {
        $mapper = $this->getMapper();
        $courseSchedule = $mapper->build( $this->entityName );
        $mapper->mapFromID( $courseSchedule, $id );

        return $course;
    }

    public function getAllByCourseID( $course_id )
    {
        $mapper = $this->getMapper();
        $courseSchedules = $mapper->mapAllFromCourseID( $course_id );

        return $courseSchedules;
    }

    public function getAllByScheduleID( $schedule_id )
    {
        $mapper = $this->getMapper();
        $courseSchedules = $mapper->mapAllFromScheduleID( $schedule_id );

        return $courseSchedules;
    }

    public function removeByID( $id )
    {
        $mapper = $this->getMapper();
        $mapper->deleteByID( $id );
    }

    public function removeByScheduleID( $schedule_id )
    {
        $mapper = $this->getMapper();
        $mapper->deleteByScheduleID( $schedule_id );
    }

    public function removeByCourseID( $id )
    {
        $mapper = $this->getMapper();
        $mapper->deleteByCourseID( $id );
    }

}
