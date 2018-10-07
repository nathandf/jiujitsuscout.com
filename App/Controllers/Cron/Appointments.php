<?php

namespace Controllers\Cron;

use \Core\Controller;

class Appointments extends Controller
{
	public function before()
	{
		$this->logger = $this->load( "logger" );
		$this->logger->info( "Cron Start: Appointments" );
	}

	public function after()
	{
		$this->logger->info( "Cron End: Appointment" );
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
		$phoneRepo = $this->load( "phone-repository" );
		$noteRegistrar = $this->load( "note-registrar" );
		$appointmentHashRepo = $this->load( "appointment-hash-repository" );

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

				// Get phone resource for business
				$phone = $phoneRepo->getByID( $business->phone_id );
				$business->phone_number = "+" . $phone->country_code . " " . $phone->national_number;

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
						$prospectPhone = $phoneRepo->getByID( $prospect->phone_id );
						$prospect->phone_number = "+" . $prospectPhone->country_code . " " . $prospectPhone->national_number;

						$user = $userRepo->getByID( $appointment->user_id );

						// Send email if remind prospect is > 0 (true)
						if ( $appointment->remind_prospect > 0 ) {

							// This hash will be added to the url in the query sting in the
							// appointment reminder email
							$appointmentHash = $appointmentHashRepo->create( $appointment->id );

							// Set email details
							$mailer->setRecipientName( $prospect->first_name );
				            $mailer->setRecipientEmailAddress( $prospect->email );
				            $mailer->setSenderName( html_entity_decode( $business->business_name, ENT_COMPAT, "UTF-8" ) );
				            $mailer->setSenderEmailAddress( $business->email );
				            $mailer->setContentType( "text/html" );
				            $mailer->setEmailSubject( "Confirm Your Appointment" );
							// Prospect email body
							$prospectEmailBody = '
							<div style="width: 100%;">
								<h2>You have a martial arts appointment!</h2>
								<table cellspacing=0 style="width: 300px; background: #FFFFFF; border-collapse: collapse; table-layout: fixed; border: 1px solid #EEE; box-sizing: border-box; padding: 15px; display: block;">
									<tr>
										<td style="font-weight: bold; padding: 20px;">Where:</td>
										<td>' . $business->business_name . '</td>
									</tr>
									<tr>
										<td style="font-weight: bold; padding: 20px;">When:</td>
										<td>' . $nice_date . ' ' . $nice_time . '</td>
									</tr>
									<tr>
										<td style="font-weight: bold; padding: 20px;">Address:</td>
										<td>' . $business->address_1 . ' ' . $business->city . ', ' . $business->region . ' ' . $business->postal_code . '</td>
									</tr>
									<tr>
										<td style="font-weight: bold; padding: 20px;">Phone Number:</td>
										<td>' . $business->phone_number . '</td>
									</tr>
								</table>
								<table cellspacing=0 style="border-collapse: collapse; table-layout: fixed; display: table; margin-top: 20px;">
									<tr>
										<td><a href="https://www.jiujitsuscout.com/email/appointment/confirm?apthash=' . $appointmentHash->hash . '" style="background: #77DD77; color: #FFFFFF; text-align: center; border-radius: 3px; display: block; width: 300px; height: 40px; line-height: 40px; font-size: 15px; font-weight: 600; text-decoration: none;">Confirm Appointment</a></td>
									</tr>
									<tr>
										<td><a href="https://www.jiujitsuscout.com/email/appointment/reschedule?apthash=' . $appointmentHash->hash . '" style="background: #FA8072; margin-top: 8px; color: #FFFFFF; text-align: center; border-radius: 3px; display: block; width: 300px; height: 40px; line-height: 40px; font-size: 15px; font-weight: 600; text-decoration: none;">Request Appointment Reschedule</a></td>
									</tr>
								</table>
								<table cellspacing=0 style="border-collapse: collapse; table-layout: fixed; display: table; margin-top: 50px;">
									<tr>
										<td style="width: 300px; text-align: center;"><span style="font-weight: 600; color: #C0C0C0;">Powered by <a href="https://www.jiujitsuscout.com/" style="text-decoration: underline; color: #C0C0C0;">JiuJitsuScout</a></span></td>
									</tr>
								</table>
								<table cellspacing=0 style="border-collapse: collapse; table-layout: fixed; display: table; margin-top: 50px;">
									<tr>
										<td style="width: 300px; text-align: center;"><span style="font-size: 12px; font-weight: 600; color: #BBBBBB;">One click <a href="https://www.jiujitsuscout.com/email/unsubscribe/" style="text-decoration: underline; color: #C0C0C0;">unsubscribe</a></span></td>
									</tr>
								</table>
							</div>';
				            $mailer->setEmailBody( $prospectEmailBody );
				            $mailStatus = $mailer->mail();

							// Log email appointment reminder status for prospect
							if ( $mailStatus != 202 ) {
								$this->logger->info( "Email Not Sent" );
							} else {
								$this->logger->info( "Email Sent: " . $prospect->email );
							}

						}

						// Send email if remind user is > 0 (true)
						if ( $appointment->remind_user > 0 ) {

							// Set email details
							$mailer->setRecipientName( $user->first_name );
				            $mailer->setRecipientEmailAddress( $user->email );
				            $mailer->setSenderName( "JiuJitsuScout" );
				            $mailer->setSenderEmailAddress( "noreply@jiujitsuscout.com" );
				            $mailer->setContentType( "text/html" );
				            $mailer->setEmailSubject( "Appointment Reminder for {$prospect->first_name}" );
							$userEmailBody = '
								<div>
									<h2 style="margin-top: 15px; margin-bottom: 25px;">You have an appointment today with ' . $prospect->first_name . ' @ ' . $nice_date . ' ' . $nice_time . '</h2>
					                <table cellspacing=0 style="width: 300px; background: #f6f7f9; border-collapse: collapse; table-layout: fixed; border: 1px solid #CCCCCC; box-sizing: border-box; padding: 15px; display: block; margin-left: 20px;">
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
					                <table cellspacing=0 style="border-collapse: collapse; table-layout: fixed; display: table; margin-left: 20px; margin-top: 20px;">
					                    <tr>
					                        <td><a href="https://www.jiujitsuscout.com/account-manager/business/lead/' . $prospect->id . '/" style="background: #77DD77; color: #FFFFFF; text-align: center; border-radius: 3px; display: block; width: 300px; height: 40px; line-height: 40px; font-size: 15px; font-weight: 600; text-decoration: none;">View in Account Manager</a></td>
					                    </tr>
					                </table>
					            </div>
							';
				            $mailer->setEmailBody( $userEmailBody );
				            $mailStatus = $mailer->mail();

							// Log email appointment reminder status for prospect
							if ( $mailStatus != 202 ) {
								$this->logger->info( "Email Not Sent" );
							} else {
								$this->logger->info( "Email Sent: " . $user->email );
							}
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
