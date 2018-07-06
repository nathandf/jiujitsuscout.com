<?php

namespace Models\Services;

class AppointmentRepository extends Service
{

    public function create( $business_id, $user_id, $prospect_id, $appointment_time, $message, $remind_user, $remind_prospect )
    {
        $appointment = new \Models\Appointment();
        $appointmentMapper = new \Models\Mappers\AppointmentMapper( $this->container );
        $appointment->business_id = $business_id;
        $appointment->user_id = $user_id;
        $appointment->prospect_id = $prospect_id;
        $appointment->appointment_time = $appointment_time;
        $appointment->message = $message;
        $appointment->setRemindAppointmentSetter( $remind_user );
        $appointment->setRemindAppointmentProspect( $remind_prospect );
        $appointmentMapper->create( $appointment );

        return $appointment;
    }

    public function getByID( $id )
    {
        $appointment = new \Models\Appointment();
        $appointmentMapper = new \Models\Mappers\AppointmentMapper( $this->container );
        $appointmentMapper->mapFromID( $appointment, $id );

        return $appointment;
    }

    public function getAllByBusinessID( $id )
    {
        $appointmentMapper = new \Models\Mappers\AppointmentMapper( $this->container );
        $appointments = $appointmentMapper->mapAllFromBusinessID( $id );

        return $appointments;
    }

    public function getAllByProspectID( $id )
    {
        $appointmentMapper = new \Models\Mappers\AppointmentMapper( $this->container );
        $appointments = $appointmentMapper->mapAllFromProspectID( $id );

        return $appointments;
    }

    public function getAllByStatus( $status )
    {
        $appointmentMapper = new \Models\Mappers\AppointmentMapper( $this->container );
        $appointments = $appointmentMapper->mapAllFromStatus( $status );

        return $appointments;
    }

    public function updateMessageByID( $id, $message )
    {
        $appointmentMapper = new \Models\Mappers\AppointmentMapper( $this->container );
        $appointmentMapper->updateMessageByID( $id, $message );
    }

    public function updateStatusByID( $id, $status )
    {
        $appointmentMapper = new \Models\Mappers\AppointmentMapper( $this->container );
        $appointmentMapper->updateStatusByID( $id, $status );
    }

    public function updateTimeByID( $id, $time )
    {
        $appointmentMapper = new \Models\Mappers\AppointmentMapper( $this->container );
        $appointmentMapper->updateTimeByID( $id, $time );
    }

    public function updateRemindStatusByID( $id )
    {
        $appointmentMapper = new \Models\Mappers\AppointmentMapper( $this->container );
        $appointmentMapper->updateRemindStatusByID( $id );
    }

    public function removeByProspectID( $prospect_id )
    {
        $appointmentMapper = new \Models\Mappers\AppointmentMapper( $this->container );
        $appointmentMapper->deleteByProspectID( $prospect_id );
    }

    public function removeByID( $id )
    {
        $appointmentMapper = new \Models\Mappers\AppointmentMapper( $this->container );
        $appointmentMapper->deleteByID( $id );
    }

}
