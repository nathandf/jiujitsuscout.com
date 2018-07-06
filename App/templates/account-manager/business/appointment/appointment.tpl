<!DOCTYPE html>
<html>
	<head>
		{include file="includes/head/account-manager-head.tpl"}
		<link type="text/css" rel="stylesheet" href="{$HOME}css/partner-lead.css">
		<link type="text/css" rel="stylesheet" href="{$HOME}css/appointment.css">
		<script rel="text/javascript" src="{$HOME}{$JS_SCRIPTS}appointment.js"></script>
	</head>
	<body>
		{include file="includes/navigation/business-manager-login-menu.tpl"}
		{include file="includes/navigation/business-manager-menu.tpl"}
		<div class="clear push-t-med"></div>
		<div id="content inner-pad-med">
			<div class="modal-overlay mod-an" style="display: none" id="reschedule-modal">
				<div class="modal" id="">
					<div class="modal-header">
						<span class="modal-close" id="reschedule-modal-close">Close</span>
						<h2 class="section-title">Reschedule Appointment</h2>
					</div><!-- end modal-header -->
					<div class="modal-body-0p">
						<div class="post-modal appointment-modal-body">
							<form method="post" action="">
								<input type="hidden" name="token" value="{$csrf_token}">
								<input type="hidden" name="reschedule" value="{$csrf_token}">
								<h2>{$lead->first_name|capitalize} {$lead->last_name|capitalize}</h2><br>
								<h3>Date</h3>
								{html_select_date class="inp field-xsml-plus cursor-pt first" start_year='-1' end_year='+3'}
								<div class="clear"></div>
								<h3>Time</h3>
								{html_select_time class="inp field-xsml cursor-pt first" minute_interval=15 display_seconds=false use_24_hours=false}
								<h3>Reminders</h3>
								<input type="checkbox" id="remind_user" class="first cursor-pt" name="remind_user" class="cursor-pt" value="true" checked="checked"> <label for="remind_user">Send me a reminder </label>
								<div class="clear"></div>
								<input type="checkbox" id="remind_prospect" class="cursor-pt" name="remind_prospect" class="cursor-pt" value="true"> <label for="remind_prospect">Send {$lead->first_name} a reminder</label>
								<input type="submit" class="btn bnt-inline floatright first" value="Reschedule Appointment">
							</form>
							<div class="clear"></div>
						</div><!-- end modal-post -->
					</div><!-- end modal-body -->
				</div><!-- end modal -->
			</div><!-- end modal-overlay -->

			<div class="clear"></div>
			<div class="lead-manager-container">
				<a class="btn btn-inline bg-lavender text-med" href="{$HOME}account-manager/business/appointments#appointment{$appointment->id}">< Appointments</a>
				<a class="btn btn-inline bg-salmon text-med floatright" href="{$HOME}account-manager/business/lead/{$lead->id}/">View Lead ></a>
				<div class="clear"></div>
				<div class="contact_display">
					<a href="{$HOME}account-manager/business/lead/{$lead->id}/" class="link text-lrg-heavy tc-deep-blue">{$lead->first_name|capitalize} {$lead->last_name|capitalize}</a>
					<div class="clear"></div>
					<p><span class="text-lrg-heavy">Date: </span>{$appointment->appointment_time|date_format:"%A, %b %e %Y"}</p>
					<p><span class="text-lrg-heavy">Time: </span>{$appointment->appointment_time|date_format:"%l:%M%p"}</p>
					<p><b>Status: </b><span class="text-med-heavy {if $appointment->status == 'pending'}tc-good-green{elseif $appointment->status == 'showed'}tc-dark-mint{else}tc-salmon{/if}">{$appointment->status|capitalize}</span></p>
				</div>
				<form method="post" action="">
					<input type="hidden" name="token" value="{$csrf_token}">
					<input type="hidden" name="trash" value="{$csrf_token}">
					<input type="hidden" name="appointment_id" value="{$appointment->id}">
					<button type="submit" class="btn btn-inline bg-red --c-trash"><i class="fa fa-trash" aria-hidden="true"></i></button>
				</form>
				<div class="clear"></div>
				{if !empty($error_messages.update_appointment)}
					{foreach from=$error_messages.update_appointment item=message}
						<div class="con-message-failure mat-hov cursor-pt --c-hide">
							<p class="user-message-body">{$message}</p>
						</div>
					{/foreach}
				{/if}
				<form class="inline-form" method="post" action="">
					<input type="hidden" name="token" value="{$csrf_token}">
					<input type="hidden" name="update_status" value="{$csrf_token}">
					<input type="hidden" name="status" value="showed">
					<button id="showed" class="btn btn-inline message-btn called"><span class="action-btn-text">Showed</span><i class="fa fa-check" aria-hidden="true"></i></button>
				</form>
				<form class="inline-form" method="post" action="">
					<input type="hidden" name="token" value="{$csrf_token}">
					<input type="hidden" name="update_status" value="{$csrf_token}">
					<input type="hidden" name="status" value="missed">
					<button type="submit" id="missed" class="btn btn-inline message-btn notice-bg"><span class="action-btn-text">Missed</span>X</button>
				</form>
				<button id="reschedule" class="btn btn-inline texted message-btn"><span class="action-btn-text">Reschedule</span><i class="fa fa-clock-o" aria-hidden="true"></i></button>
				<div class="con-cnt-lrg">
					{if !empty($error_messages.add_note)}
						{foreach from=$error_messages.add_note item=message}
							<div class="con-message-failure mat-hov cursor-pt --c-hide">
								<p class="user-message-body">{$message}</p>
							</div>
						{/foreach}
					{/if}
					<form method="post" action="">
						<input type="hidden" name="token" value="{$csrf_token}">
						<input type="hidden" name="add_note" value="{$csrf_token}">
						<textarea class="notes" name="note_body" placeholder="Save your notes about the appointment with {$lead->first_name|capitalize} {$lead->last_name|capitalize}">{$appointment->message}</textarea>
						<div class="clear"></div>
						<button type="submit" name="save-note" value="post" class="btn btn-inline">Save Note</button>
						<div class="clear"></div>
					</form>
				</div><!-- end post -->
				<div class="clear"></div>
				<div id="notes">
					{foreach from=$notes item=note}
					<div class="note-tag" id="note{$note->id}">
						<form method="post" action="">
							<input type="hidden" name="token" value="{$csrf_token}">
							<input type="hidden" name="note_id" value="{$note->id}">
							<input type="hidden" name="delete_note" value="{$csrf_token}">
							<button type="submit" class="bg-white floatright"><p class="text-lrg-heavy link tc-salmon">x</p></button>
						</form>
						<p class="text-sml-heavy">{$note->time|date_format:"%b %e %Y - %l:%M%p"}</p>
						<div class="clear"></div>
						<p class="text-med first">{$note->body}</p>
						<div class="clear"></div>
					</div>
					{/foreach}
				</div>
			</div><!-- end lead-manager-container -->
			<div class="clear"></div>
		</div><!-- end content -->
	</body>
</html>
