<?php

namespace Controllers\Cron;

use \Core\Controller;

class Trials extends Controller
{
	public function before()
	{
		$this->logger = $this->load( "logger" );
		$this->logger->info( "Cron Start: Trials -----------------------" );
	}

	public function after()
	{
		$this->logger->info( "Cron End: Trials -------------------------" );
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
		$phoneRepo = $this->load( "phone-repository" );

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

				// Get prospects phone resource
				$phone = $phoneRepo->getByID( $prospect->phone_id );

				$prospect->phone_number = "+" . $phone->country_code . " " . $phone->national_number;

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
					$businessEmailBody = '
						<div>
							<h2 style="margin-top: 15px; margin-bottom: 25px;">Trial ending soon for ' . $prospect->first_name . '</h2>
							<table cellspacing=0 style="width: 300px; background: #f6f7f9; border-collapse: collapse; table-layout: fixed; border: 1px solid #CCCCCC; box-sizing: border-box; padding: 15px; display: block;">
							<tr>
								<td style="font-weight: bold; padding: 15px;">Trial End:</td>
								<td>' . date( "Y-m-d", $prospect->trial_end ) . '</td>
							</tr>
								<tr>
									<td style="font-weight: bold; padding: 15px;">Name:</td>
									<td>' . $prospect->first_name . '</td>
								</tr>
								<tr>
									<td style="font-weight: bold; padding: 15px;">Email:</td>
									<td>' . $prospect->email . '</td>
								</tr>
								<tr>
									<td style="font-weight: bold; padding: 15px;">Phone Number:</td>
									<td>' . $prospect->phone_number . '</td>
								</tr>
								<tr>
									<td style="font-weight: bold; padding: 15px;">Source:</td>
									<td><p sytle="max-width: 50ch;">' . $prospect->source . '</p></td>
								</tr>
							</table>
							<table cellspacing=0 style="border-collapse: collapse; table-layout: fixed; display: table; margin-top: 20px;">
								<tr>
									<td><a href="https://www.jiujitsuscout.com/account-manager/business/lead/' . $prospect->id . '/" style="background: #77DD77; color: #FFFFFF; text-align: center; border-radius: 3px; display: block; width: 300px; height: 40px; line-height: 40px; font-size: 15px; font-weight: 600; text-decoration: none;">View in Account Manager</a></td>
								</tr>
							</table>
						</div>
					';

					// Set email details
					$mailer->setRecipientName( $business->business_name );
		            $mailer->setRecipientEmailAddress( $business->email );
		            $mailer->setSenderName( "JiuJitsuScout" );
		            $mailer->setSenderEmailAddress( "notifcations@jiujitsuscout.com" );
		            $mailer->setContentType( "text/html" );
		            $mailer->setEmailSubject( $subject );
		            $mailer->setEmailBody( $businessEmailBody );
		            $mailStatus = $mailer->mail();

					// Log email trial reminder
					if ( $mailStatus != 202 ) {
						$this->logger->info( "Email Not Sent" );
					} else {
						$this->logger->info( "Email Sent: " . $business->email );
					}

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
