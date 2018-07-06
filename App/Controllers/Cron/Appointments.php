<?php

namespace Controllers\Cron;

use \Core\Controller;

class Appointments extends Controller
{
	public function before()
	{
		// TODO log beginning of job
	}

	public function after()
	{
		// TODO log end of job
		die();
		exit();
	}

	public function indexAction()
	{
		$appointmentRepo = $this->load( "appointment-repository" );
		$input = $this->load( "input" );
		$inputValidator = $this->load( "input-validator" );
		$mailer = $this->load( "mailer" );
		$prospectRepo = $this->load( "prospect-repository" );
		$userRepo = $this->load( "user-repository" );
		$businessRepo = $this->load( "business-repository" );
		$noteRegistrar = $this->load( "note-registrar" );

		// Set empty appointments array
		$appointments = [];

		// Start time for job
		$now = time();

		// Default reminder offset. This will be subtracted from appointment time. Will send email 1hr earlier than appt time (in seconds)
		$reminder_offset = 3600;

		// Only run script if cron_token is present
		if ( $input->exists( "get" ) && $inputValidator->validate(

				$input,

				[
					"cron_token" => [
						"required" => true
					]
				],

				null /* error index */

			) )
		{
			// Get all pending appointments
			$appointments = $appointmentRepo->getAllByStatus( "pending" );

			foreach ( $appointments as $appointment ) {

				// Set nicely formatted time and date
				$nice_time = date( "g:iA", $appointment->appointment_time );
				$nice_date = date( "D, M jS", $appointment->appointment_time );

				// Get the current business for appointment
				$business = $businessRepo->getByID( $appointment->business_id );

				// Get UTC DateTimeZone object and DateTimeZone object for businesses timezone
				$dateTimeZoneServer = new \DateTimeZone( date_default_timezone_get() );
				$dateTimeZoneBusiness = new \DateTimeZone( $business->timezone );

				// Get DateTime object from DateTimeZone Object
				$dateTimeServer = new \DateTime( "now", $dateTimeZoneServer );
				$dateTimeBusiness = new \DateTime( "now", $dateTimeZoneBusiness );

				// Get time offset in seconds
				$time_offset = $dateTimeZoneServer->getOffset( $dateTimeServer ) - $dateTimeZoneBusiness->getOffset( $dateTimeBusiness );

				// Send reminder emails if it's the proper time and if they haven't already been reminded
				if ( ( ( $appointment->appointment_time + $time_offset ) - $reminder_offset <= $now ) && $appointment->remind_status < 1 ) {

					// Require prospect id and user id before sending email
					if ( !is_null( $appointment->prospect_id ) && !is_null( $appointment->user_id ) ) {

						// Get prospect and user data
						$prospect = $prospectRepo->getByID( $appointment->prospect_id );
						$user = $userRepo->getByID( $appointment->user_id );

						// Send email if remind prospect is > 0 (true)
						if ( $appointment->remind_prospect > 0 ) {

							// Set email details
							$mailer->setRecipientName( $prospect->first_name );
				            $mailer->setRecipientEmailAddress( $prospect->email );
				            $mailer->setSenderName( $business->business_name );
				            $mailer->setSenderEmailAddress( $business->email );
				            $mailer->setContentType( "text/html" );
				            $mailer->setEmailSubject( "Confirm Your Appointment" );
				            $mailer->setEmailBody( "
								You have a martial arts appointment at {$nice_time} on {$nice_date} at {$business->business_name}
							" );
				            $mailer->mail();
						}

						// Send email if remind user is > 0 (true)
						if ( $appointment->remind_user > 0 ) {

							// Set email details
							$mailer->setRecipientName( $user->first_name );
				            $mailer->setRecipientEmailAddress( $user->email );
				            $mailer->setSenderName( "JiuJitsuScout" );
				            $mailer->setSenderEmailAddress( "no_reply@jiujitsuscout.com" );
				            $mailer->setContentType( "text/html" );
				            $mailer->setEmailSubject( "Lead Appointment Reminder for {$prospect->first_name}" );
				            $mailer->setEmailBody( "
								You have an appointment with " . ucfirst( $prospect->first_name ) . " at {$nice_time} on {$nice_date}
							" );
				            $mailer->mail();
						}

						// Update remind status for appointment
						$appointmentRepo->updateRemindStatusByID( $appointment->id );

						// Update notes for prospect and appointment
						$noteRegistrar->save(
							"{$prospect->first_name} was sent an appointment confimation email",
							$business->id,
							$user->id,
							$prospect->id,
							$member_id = null,
							$appointment->id
						);

						// Update times contacted +1
						$prospectRepo->updateTimesContactedByID( ( $prospect->times_contacted + 1 ), $prospect->id );
					}
				}
			}
		}
	}
}
