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

        $this->populateSchedule( $schedule, $resp );

        return $schedule;
    }

    public function mapAllFromBusinessID( $business_id )
    {
        $entityFactory = $this->container->getService( "entity-factory" );
        $schedules = [];
        $sql = $this->DB->prepare( 'SELECT * FROM schedule WHERE business_id = :business_id' );
        $sql->bindParam( ":business_id", $business_id );
        $sql->execute();
        while ( $resp = $sql->fetch( \PDO::FETCH_ASSOC ) ) {
            $schedule = $entityFactory->build( "Schedule" );
            $this->populateSchedule( $schedule, $resp );
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

    private function populateSchedule( \Model\Schedule $schedule, $data )
    {
        $schedule->id                      = $data[ "id" ];
        $schedule->business_id             = $data[ "business_id" ];
        $schedule->name                    = $data[ "name" ];
        $schedule->description             = $data[ "description" ];
    }

}
