<?php

namespace Model;

use Contracts\EntityInterface;

class Appointment implements EntityInterface
{

    public $business_id;
    public $prospect_id;
    public $user_id;
    public $appointment_time;
    public $message;
    public $remind_user;
    public $remind_prospect;
    public $remind_status;
    public $status;

    public function setBusinessID( $id )
    {
        $this->business_id = $id;
    }

    public function setProspectID( $id )
    {
        $this->prospect_id = $id;
    }

    public function setUserID( $id )
    {
        $this->user_id = $id;
    }

    public function setAppointmentTimeUTC( $timestamp )
    {
        $this->appointment_time = $timestamp;
    }

    public function setMessage( $message )
    {
        $this->message = $message;
    }

    public function setRemindAppointmentSetter( $remind )
    {
        $this->remind_user = 0;

        if ( $remind == "true" ) {
            $this->remind_user = 1;
        }
    }

    public function setRemindAppointmentProspect( $remind )
    {
        $this->remind_prospect = 0;

        if ( $remind == "true" ) {
            $this->remind_prospect = 1;
        }
    }

    public function setStatus( $status )
    {
        $this->status = $status;
    }

}
