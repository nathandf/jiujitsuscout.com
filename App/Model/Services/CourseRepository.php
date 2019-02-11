<?php

namespace Model\Services;

use Model\Course;
use Model\Mappers\CourseMapper;

class CourseRepository extends Repository
{

    public function create( $business_id, $discipline_id, $name, $description, $day, $start_time, $end_time )
    {
        $mapper = $this->getMapper();
        $course = $mapper->build( $this->entityName );
        $course->business_id = $business_id;
        $course->discipline_id = $discipline_id;
        $course->name = $name;
        $course->description = $description;
        $course->day = trim( strtolower( $day ) );
        $course->start_time = $start_time;
        $course->end_time = $end_time;
        $mapper->create( $course );

        return $course;
    }

    public function getByID( $id )
    {
        $mapper = $this->getMapper();
        $course = $mapper->build( $this->entityName );
        $mapper->mapFromID( $course, $id );

        return $course;
    }

    public function getAllByBusinessID( $business_id )
    {
        $mapper = $this->getMapper();
        $courses = $mapper->mapAllFromBusinessID( $business_id );

        return $courses;
    }

    public function removeByID( $id )
    {
        $mapper = $this->getMapper();
        $mapper->deleteByID( $id );
    }

}
