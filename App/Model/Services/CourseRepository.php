<?php

namespace Model\Services;

use Model\Course;
use Model\Mappers\CourseMapper;

class CourseRepository extends Service
{

    public function create( $business_id, $discipline_id, $name, $description, $day, $start_time, $end_time )
    {
        $course = new Course();
        $courseMapper = new CourseMapper( $this->container );
        $course->business_id = $business_id;
        $course->discipline_id = $discipline_id;
        $course->name = $name;
        $course->description = $description;
        $course->day = trim( strtolower( $day ) );
        $course->start_time = $start_time;
        $course->end_time = $end_time;
        $courseMapper->create( $course );

        return $course;
    }

    public function getByID( $id )
    {
        $course = new Course();
        $courseMapper = new CourseMapper( $this->container );
        $courseMapper->mapFromID( $course, $id );

        return $course;
    }

    public function getAllByBusinessID( $business_id )
    {
        $courseMapper = new \Model\Mappers\CourseMapper( $this->container );
        $courses = $courseMapper->mapAllFromBusinessID( $business_id );

        return $courses;
    }

    public function removeByID( $id )
    {
        $courseMapper = new \Model\Mappers\CourseMapper( $this->container );
        $courseMapper->deleteByID( $id );
    }

}
