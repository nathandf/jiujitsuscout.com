<?php

namespace Model\Services;

class AppointmentRepository extends Repository
{

    public function create( $business_id, $user_id, $prospect_id, $appointment_time, $message, $remind_user, $remind_prospect )
    {
        $mapper = $this->getMapper();
        $appointment = $mapper->build( $this->entityName );
        $appointment->business_id = $business_id;
        $appointment->user_id = $user_id;
        $appointment->prospect_id = $prospect_id;
        $appointment->appointment_time = $appointment_time;
        $appointment->message = $message;
        $appointment->setRemindAppointmentSetter( $remind_user );
        $appointment->setRemindAppointmentProspect( $remind_prospect );
        $mapper->create( $appointment );

        return $appointment;
    }

    public function getByID( $id )
    {
        $mapper = $this->getMapper();
        $appointment = $mapper->build( $this->entityName );
        $mapper->mapFromID( $appointment, $id );

        return $appointment;
    }

    public function getAllByBusinessID( $id )
    {
        $mapper = $this->getMapper();
        $appointments = $mapper->mapAllFromBusinessID( $id );

        return $appointments;
    }

    public function getAllByProspectID( $id )
    {
        $mapper = $this->getMapper();
        $appointments = $mapper->mapAllFromProspectID( $id );

        return $appointments;
    }

    public function getAllByStatus( $status )
    {
        $mapper = $this->getMapper();
        $appointments = $mapper->mapAllFromStatus( $status );

        return $appointments;
    }

    public function updateMessageByID( $id, $message )
    {
        $mapper = $this->getMapper();
        $mapper->updateMessageByID( $id, $message );
    }

    public function updateStatusByID( $id, $status )
    {
        $mapper = $this->getMapper();
        $mapper->updateStatusByID( $id, $status );
    }

    public function updateTimeByID( $id, $time )
    {
        $mapper = $this->getMapper();
        $mapper->updateTimeByID( $id, $time );
    }

    public function updateRemindStatusByID( $id )
    {
        $mapper = $this->getMapper();
        $mapper->updateRemindStatusByID( $id );
    }

    public function removeByProspectID( $prospect_id )
    {
        $mapper = $this->getMapper();
        $mapper->deleteByProspectID( $prospect_id );
    }

    public function removeByID( $id )
    {
        $mapper = $this->getMapper();
        $mapper->deleteByID( $id );
    }

}
