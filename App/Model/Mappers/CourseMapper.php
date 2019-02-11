<?php

namespace Model\Mappers;

use Model\Course;

class CourseMapper extends DataMapper
{
    public function create( \Model\Course $course )
    {
        $id = $this->insert(
            "course",
            [ "business_id", "discipline_id", "name", "description", "day", "start_time", "end_time" ],
            [ $course->business_id, $course->discipline_id, $course->name, $course->description, $course->day, $course->start_time, $course->end_time ]
        );
        $course->id = $id;

        return $course;
    }

    public function mapFromID( Course $course, $id )
    {
        $sql = $this->DB->prepare( 'SELECT * FROM course WHERE id = :id' );
        $sql->bindParam( ":id", $id );
        $sql->execute();
        $resp = $sql->fetch( \PDO::FETCH_ASSOC );

        $this->populate( $course, $resp );

        return $course;
    }

    public function mapAllFromBusinessID( $business_id )
    {
        $courses = [];
        $sql = $this->DB->prepare( "SELECT * FROM course WHERE business_id = :business_id" );
        $sql->bindParam( ":business_id", $business_id );
        $sql->execute();
        while ( $resp = $sql->fetch( \PDO::FETCH_ASSOC ) ) {
            $course = $this->entityFactory->build( "Course" );
            $this->populate( $course, $resp );
            $courses[] = $course;
        }

        return $courses;
    }

    public function deleteByID( $id )
    {
        $sql = $this->DB->prepare( "DELETE FROM course WHERE id = :id" );
        $sql->bindParam( ":id", $id );
        $sql->execute();
    }
}
