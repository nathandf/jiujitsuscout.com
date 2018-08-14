<?php

namespace Controllers\Email;

use \Core\Controller;

class Appointment extends Controller
{
	public function indexAction()
	{
		$this->view->redirect( "" );
	}

	public function confirm()
	{
		$input = $this->load( "input" );
		$inputValidator = $this->load( "input-validator" );
		$appointmentRepo = $this->load( "appointment-repository" );
		$appointmentHashRepo = $this->load( "appointment-hash-repository" );
		$prospectRepo = $this->load( "prospect-repository" );
		$noteRegistrar = $this->load( "note-registrar" );
		$userMailer = $this->load( "user-mailer" );
		$userRepo = $this->load( "user-repository" );
		$phoneRepo = $this->load( "phone-repository" );

		// Verify that the query string contains the variable 'apthash'. If true,
		// Update appointment as confirmed and create a note about the confirmation.
		if ( $input->exists( "get" ) && $inputValidator->validate(
				$input,
				[
					"apthash" => [
						"required" => true
					]
				],
				"confirm_appointment"
			) )
		{
			// Get appointment has specified in the query string
			$appointmentHash = $appointmentHashRepo->getByHash( $input->get( "apthash" ) );

			if ( !is_null( $appointmentHash->id ) ) {
				// Get appointment object from id provided by the appointment hash
				$appointment = $appointmentRepo->getByID($appointmentHash->appointment_id);

				// Get user associated with this appointment
				$user = $userRepo->getByID( $appointment->user_id );

				// Get the prospect associated with this appointment
				$prospect = $prospectRepo->getByID( $appointment->prospect_id );
				$prospectPhone = $phoneRepo->getByID( $prospect->phone_id );

				// Create a note about confired appointment
				$noteBody = $prospect->getFullName() . " has confirmed their appointment for " . date( "l, M jS @ g:iA", $appointment->appointment_time ) . ".";
				$noteRegistrar->save(
					$noteBody,
					$appointment->business_id,
					null,
					$prospect->id,
					null,
					$appointment->id
				);

				// Notify the user associated with this appointment of the appointment confirmation
				$userMailer->sendAppointmentConfirmationNotification(
					$user->getFullName(),
					$user->email,
					$appointment->appointment_time,
					$prospect_info = [
						"name" => $prospect->getFullName(),
						"email" => $prospect->email,
						"phone" => "+" . $prospectPhone->country_code . " " . $prospectPhone->national_number,
						"id" => $prospect->id
					]
				);

				// Delete the appointment hash after all appointment confirmation
				// action were completed
				$appointmentHashRepo->removeByID( $appointmentHash->id );
			}

		}

		$this->view->setTemplate( "email/appointment/appointment-confirmation-success.tpl" );
        $this->view->render( "App/Views/Email/Appointment.php" );
	}

	public function reschedule()
	{
		$input = $this->load( "input" );
		$inputValidator = $this->load( "input-validator" );
		$appointmentRepo = $this->load( "appointment-repository" );
		$appointmentHashRepo = $this->load( "appointment-hash-repository" );
		$prospectRepo = $this->load( "prospect-repository" );
		$noteRegistrar = $this->load( "note-registrar" );
		$userRepo = $this->load( "user-repository" );
		$phoneRepo = $this->load( "phone-repository" );
		$userMailer = $this->load( "user-mailer" );

		// Verify that the query string contains the variable 'apthash'. If true,
		// Create a note about the request to reschedule
		if ( $input->exists( "get" ) && $inputValidator->validate(
				$input,
				[
					"apthash" => [
						"required" => true
					]
				],
				"request_appointment_reschedule"
			) )
		{
			// Get appointment has specified in the query string
			$appointmentHash = $appointmentHashRepo->getByHash( $input->get( "apthash" ) );

			if ( !is_null( $appointmentHash->id ) ) {
				// Get appointment object from id provided by the appointment hash
				$appointment = $appointmentRepo->getByID($appointmentHash->appointment_id);

				// Get user associated with this appointment
				$user = $userRepo->getByID( $appointment->user_id );

				// Get the prospect associated with this appointment
				$prospect = $prospectRepo->getByID( $appointment->prospect_id );
				$prospectPhone = $phoneRepo->getByID( $prospect->phone_id );

				// Create a note about rescheduling the appointment
				$noteBody = $prospect->getFullName() . " has requested to reschedule their appointment.";
				$noteRegistrar->save(
					$noteBody,
					$appointment->business_id,
					null,
					$prospect->id,
					null,
					$appointment->id
				);

				// Notify the user associated with this appointment of the appointment confirmation
				$userMailer->sendAppointmentRescheduleNotification(
					$user->getFullName(),
					$user->email,
					$prospect_info = [
						"name" => $prospect->getFullName(),
						"email" => $prospect->email,
						"phone" => "+" . $prospectPhone->country_code . " " . $prospectPhone->national_number,
						"id" => $prospect->id
					]
				);

				// Delete the appointment hash after all appointment confirmation
				// action were completed
				$appointmentHashRepo->removeByID( $appointmentHash->id );
			}

		}

		$this->view->setTemplate( "email/appointment/appointment-reschedule-requested.tpl" );
	    $this->view->render( "App/Views/Email/Appointment.php" );
	}
}
