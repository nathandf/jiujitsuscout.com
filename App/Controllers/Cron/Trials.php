<?php

namespace Controllers\Cron;

use \Core\Controller;

class Trials extends Controller
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
		$input = $this->load( "input" );
		$inputValidator = $this->load( "input-validator" );
		$mailer = $this->load( "mailer" );
		$prospectRepo = $this->load( "prospect-repository" );
		$businessRepo = $this->load( "business-repository" );
		$noteRegistrar = $this->load( "note-registrar" );

		// Set empty trials array
		$trials = [];

		// Start time for job
		$now = time();

		// Default reminder offset. This will be subtracted from trial end time. Will send email day earlier than trial end time time (in seconds)
		$reminder_offset = 3600 * 24;

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
			$prospects = $prospectRepo->getAllByType( "trial" );

			foreach ( $prospects as $prospect ) {

				// Set nicely formatted time and date
				// Start
				$nice_time_start = date( "g:iA", $prospect->trial_start );
				$nice_date_start = date( "D, M jS", $prospect->trial_start );
				// End
				$nice_time_end = date( "g:iA", $prospect->trial_end );
				$nice_date_end = date( "D, M jS", $prospect->trial_end );

				// Get the current business for appointment
				$business = $businessRepo->getByID( $prospect->business_id );

				// Get UTC DateTimeZone object and DateTimeZone object for businesses timezone
				$dateTimeZoneServer = new \DateTimeZone( date_default_timezone_get() );
				$dateTimeZoneBusiness = new \DateTimeZone( $business->timezone );

				// Get DateTime object from DateTimeZone Object
				$dateTimeServer = new \DateTime( "now", $dateTimeZoneServer );
				$dateTimeBusiness = new \DateTime( "now", $dateTimeZoneBusiness );

				// Get time offset in seconds
				$time_offset = $dateTimeZoneServer->getOffset( $dateTimeServer ) - $dateTimeZoneBusiness->getOffset( $dateTimeBusiness );

				// Send reminder emails if it's the proper time and if they haven't already been reminded
				if ( ( ( $prospect->trial_end + $time_offset ) - $reminder_offset <= $now ) && $prospect->trial_remind_status < 1 ) {

					// Email subject
					$subject = "Trial ending for " . $prospect->first_name . " " . $prospect->last_name;
					$email_body = "Trial for " . $prospect->first_name . " " . $prospect->last_name . " will end on {$nice_date_end}" ;

					// Set email details
					$mailer->setRecipientName( $business->business_name );
		            $mailer->setRecipientEmailAddress( $business->email );
		            $mailer->setSenderName( "JiuJitsuScout" );
		            $mailer->setSenderEmailAddress( "no_reply@jiujitsuscout.com" );
		            $mailer->setContentType( "text/html" );
		            $mailer->setEmailSubject( $subject );
		            $mailer->setEmailBody( $email_body );
		            $mailer->mail();

					// Update trial remind status for prospect
					$prospectRepo->updateTrialRemindStatusByID( $prospect->id );

					// Update notes for prospect and trial
					$noteRegistrar->save(
						"Trial ends {$nice_date_end} - JiuJitsuScout",
						$business->id,
						$user_id = null,
						$prospect->id,
						$member_id = null,
						$appointment_id = null
					);
				}
			}
		}
	}
}
