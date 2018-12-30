<?php

namespace Model\Mappers;

use Model\Schedule;

class ScheduleMapper extends DataMapper
{
    public function create( \Model\Schedule $schedule )
    {
        $id = $this->insert(
            "schedule",
            [ "business_id", "name", "description" ],
            [ $schedule->business_id, $schedule->name, $schedule->description ]
        );
        $schedule->id = $id;

        return $schedule;
    }

    public function mapFromID( Schedule $schedule, $id )
    {
        $sql = $this->DB->prepare( 'SELECT * FROM schedule WHERE id = :id' );
        $sql->bindParam( ":id", $id );
        $sql->execute();
        $resp = $sql->fetch( \PDO::FETCH_ASSOC );

        $this->populate( $schedule, $resp );

        return $schedule;
    }

    public function mapAllFromBusinessID( $business_id )
    {
        $schedules = [];
        $sql = $this->DB->prepare( 'SELECT * FROM schedule WHERE business_id = :business_id' );
        $sql->bindParam( ":business_id", $business_id );
        $sql->execute();

        while ( $resp = $sql->fetch( \PDO::FETCH_ASSOC ) ) {
            $schedule = $this->entityFactory->build( "Schedule" );
            $this->populate( $schedule, $resp );
            $schedules[] = $schedule;
        }

        return $schedules;
    }

    public function updateByID( $id, $name, $description )
    {
        $this->update( "schedule", "name", $name, "id", $id );
        $this->update( "schedule", "description", $description, "id", $id );
    }

    public function deleteByID( $id )
    {
        $sql = $this->DB->prepare( "DELETE FROM schedule WHERE id = :id" );
        $sql->bindParam( ":id", $id );
        $sql->execute();
    }
}
