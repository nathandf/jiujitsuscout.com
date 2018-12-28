<?php

namespace Model\Mappers;

use Model\Appointment;

class AppointmentMapper extends DataMapper
{

  public function create( \Model\Appointment $appointment )
  {
    $id = $this->insert(
                    "appointment",
                    [ "business_id", "user_id", "prospect_id", "appointment_time", "message", "remind_user", "remind_prospect", "remind_status" ],
                    [ $appointment->business_id, $appointment->user_id, $appointment->prospect_id, $appointment->appointment_time, $appointment->message, $appointment->remind_user, $appointment->remind_prospect, 0 ]
                  );
    $appointment->id = $id;
    return $appointment;
  }

  public function mapFromID( Appointment $appointment, $id )
  {
    $sql = $this->DB->prepare( "SELECT * FROM appointment WHERE id = :id" );
    $sql->bindParam( ":id", $id );
    $sql->execute();
    $resp = $sql->fetch( \PDO::FETCH_ASSOC );
    $this->populateAppointment( $appointment, $resp );
    return $appointment;
  }

  public function mapAllFromBusinessID( $business_id )
  {
    
    $appointments = [];
    $sql = $this->DB->prepare( "SELECT * FROM appointment WHERE business_id = :business_id ORDER BY appointment_time DESC" );
    $sql->bindParam( ":business_id", $business_id );
    $sql->execute();
    while ( $resp = $sql->fetch( \PDO::FETCH_ASSOC ) ) {
      $appointment = $this->entityFactory->build( "Appointment" );
      $this->populateAppointment( $appointment, $resp );

      $appointments[] = $appointment;
    }

    return $appointments;
  }

  public function mapAllFromProspectID( $prospect_id )
  {
    
    $appointments = [];
    $sql = $this->DB->prepare( "SELECT * FROM appointment WHERE prospect_id = :prospect_id ORDER BY appointment_time DESC" );
    $sql->bindParam( ":prospect_id", $prospect_id );
    $sql->execute();
    while ( $resp = $sql->fetch( \PDO::FETCH_ASSOC ) ) {
      $appointment = $this->entityFactory->build( "Appointment" );
      $this->populateAppointment( $appointment, $resp );

      $appointments[] = $appointment;
    }

    return $appointments;
  }

    public function mapAllFromStatus( $status )
    {
        
        $appointments = [];
        $sql = $this->DB->prepare( "SELECT * FROM appointment WHERE status = :status ORDER BY appointment_time DESC" );
        $sql->bindParam( ":status", $status );
        $sql->execute();
        while ( $resp = $sql->fetch( \PDO::FETCH_ASSOC ) ) {
            $appointment = $this->entityFactory->build( "Appointment" );
            $this->populateAppointment( $appointment, $resp );

            $appointments[] = $appointment;
        }

        return $appointments;
    }

  public function updateMessageByID( $id, $message )
  {
    $this->update( "appointment", "message", $message, "id", $id );
  }

  public function updateStatusByID( $id, $status )
  {
    $this->update( "appointment", "status", $status, "id", $id );
  }

  public function updateTimeByID( $id, $time )
  {
    $this->update( "appointment", "appointment_time", $time, "id", $id );
  }

    public function updateRemindStatusByID( $id )
    {
        $remind_status = 1;
        $this->update( "appointment", "remind_status", $remind_status, "id", $id );
    }

    public function deleteByID( $id )
    {
        $sql = $this->DB->prepare( "DELETE FROM appointment WHERE id = :id" );
        $sql->bindParam( ":id", $id );
        $sql->execute();
    }

    public function deleteByProspectID( $prospect_id )
    {
        $sql = $this->DB->prepare( "DELETE FROM appointment WHERE prospect_id = :prospect_id" );
        $sql->bindParam( ":prospect_id", $prospect_id );
        $sql->execute();
    }

  public function populateAppointment( $appointment, $data )
  {
    $appointment->id                          = $data[ "id" ];
    $appointment->business_id                 = $data[ "business_id" ];
    $appointment->user_id                     = $data[ "user_id" ];
    $appointment->prospect_id                 = $data[ "prospect_id" ];
    $appointment->appointment_time            = $data[ "appointment_time" ];
    $appointment->message                     = $data[ "message" ];
    $appointment->remind_user                 = $data[ "remind_user" ];
    $appointment->remind_prospect             = $data[ "remind_prospect" ];
    $appointment->remind_status               = $data[ "remind_status" ];
    $appointment->status                      = $data[ "status" ];
  }

}
