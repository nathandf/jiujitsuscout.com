<?php

namespace Models\Mappers;

use Models\Course;

class CourseMapper extends DataMapper
{

    public function create( \Models\Course $course )
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

        $this->populateCourse( $course, $resp );

        return $course;
    }

    public function mapAllFromBusinessID( $business_id )
    {
        $entityFactory = $this->container->getService( "entity-factory" );
        $courses = [];
        $sql = $this->DB->prepare( "SELECT * FROM course WHERE business_id = :business_id" );
        $sql->bindParam( ":business_id", $business_id );
        $sql->execute();
        while ( $resp = $sql->fetch( \PDO::FETCH_ASSOC ) ) {
            $course = $entityFactory->build( "Course" );
            $this->populateCourse( $course, $resp );
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

    private function populateCourse( \Models\Course $course, $data )
    {
        $course->id                      = $data[ "id" ];
        $course->business_id             = $data[ "business_id" ];
        $course->discipline_id           = $data[ "discipline_id" ];
        $course->name                    = $data[ "name" ];
        $course->description             = $data[ "description" ];
        $course->day                     = $data[ "day" ];
        $course->start_time              = $data[ "start_time" ];
        $course->end_time                = $data[ "end_time" ];
    }

}
