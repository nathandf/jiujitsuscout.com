<?php

namespace Model\Mappers;

use Model\Course;

class CourseScheduleMapper extends DataMapper
{

    public function create( \Model\CourseSchedule $courseSchedule )
    {
        $id = $this->insert(
            "course_schedule",
            [ "course_id", "schedule_id" ],
            [ $courseSchedule->course_id, $courseSchedule->schedule_id ]
        );
        $courseSchedule->id = $id;

        return $courseSchedule;
    }

    public function mapFromID( CourseSchedule $courseSchedule, $id )
    {
        $sql = $this->DB->prepare( 'SELECT * FROM course_schedule WHERE id = :id' );
        $sql->bindParam( ":id", $id );
        $sql->execute();
        $resp = $sql->fetch( \PDO::FETCH_ASSOC );

        $this->populateCourseSchedule( $courseSchedule, $resp );

        return $courseSchedule;
    }

    public function mapAllFromScheduleID( $schedule_id )
    {
        
        $courseSchedules = [];
        $sql = $this->DB->prepare( "SELECT * FROM course_schedule WHERE schedule_id = :schedule_id" );
        $sql->bindParam( ":schedule_id", $schedule_id );
        $sql->execute();
        while ( $resp = $sql->fetch( \PDO::FETCH_ASSOC ) ) {
            $courseSchedule = $this->entityFactory->build( "CourseSchedule" );
            $this->populateCourseSchedule( $courseSchedule, $resp );
            $courseSchedules[] = $courseSchedule;
        }

        return $courseSchedules;
    }

    public function mapAllFromCourseID( $course_id )
    {
        
        $courseSchedules = [];
        $sql = $this->DB->prepare( "SELECT * FROM course_schedule WHERE course_id = :course_id" );
        $sql->bindParam( ":course_id", $course_id );
        $sql->execute();
        while ( $resp = $sql->fetch( \PDO::FETCH_ASSOC ) ) {
            $courseSchedule = $this->entityFactory->build( "CourseSchedule" );
            $this->populateCourseSchedule( $courseSchedule, $resp );
            $courseSchedules[] = $courseSchedule;
        }

        return $courseSchedules;
    }

    public function deleteByID( $id )
    {
        $sql = $this->DB->prepare( "DELETE FROM course_schedule WHERE id = :id" );
        $sql->bindParam( ":id", $id );
        $sql->execute();
    }

    public function deleteByScheduleID( $schedule_id )
    {
        $sql = $this->DB->prepare( "DELETE FROM course_schedule WHERE schedule_id = :schedule_id" );
        $sql->bindParam( ":schedule_id", $schedule_id );
        $sql->execute();
    }

    public function deleteByCourseID( $course_id )
    {
        $sql = $this->DB->prepare( "DELETE FROM course_schedule WHERE course_id = :course_id" );
        $sql->bindParam( ":course_id", $course_id );
        $sql->execute();
    }

    private function populateCourseSchedule( \Model\CourseSchedule $courseSchedule, $data )
    {
        $courseSchedule->id                      = $data[ "id" ];
        $courseSchedule->course_id               = $data[ "course_id" ];
        $courseSchedule->schedule_id             = $data[ "schedule_id" ];
    }

}
