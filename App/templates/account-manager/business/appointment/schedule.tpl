<!DOCTYPE html>
<html>
	<head>
		{include file="includes/head/account-manager-head.tpl"}
		<link rel="stylesheet" type="text/css" href="{$HOME}public/css/leads.css"/>
	</head>
	<body>
		{include file="includes/navigation/business-manager-login-menu.tpl"}
	    {include file="includes/navigation/business-manager-menu.tpl"}
		<div class="con-cnt-xxlrg first inner-pad-med">
			{if !empty($error_messages.schedule_appointment)}
				{foreach from=$error_messages.schedule_appointment item=message}
					<div class="con-message-failure mat-hov cursor-pt --c-hide">
						<p class="user-message-body">{$message}</p>
					</div>
				{/foreach}
			{/if}
			<form action="{$HOME}account-manager/business/appointment/schedule">
				<input type="hidden" name="prospect_id" value="{$lead->id}">
				<input type="hidden" name="token" value="{$csrf_token}">
				<input type="hidden" name="schedule" value="true">
				<h2>Schedule Appointment</h2>
				<p class="last"><b>For: </b>{$lead->first_name|capitalize} {$lead->last_name|capitalize}</p>
				<h3 class="first">Date</h3>
				{html_select_date class="inp field-sml cursor-pt first" start_year='-1' end_year='+3'}
				<div class="clear"></div>
				<h3>Time</h3>
				{html_select_time class="inp field-sml cursor-pt first" minute_interval=15 display_seconds=false use_24_hours=false}
				<h3>Reminders</h3>
				<input type="checkbox" id="remind_user" class="first cursor-pt" name="remind_user" class="cursor-pt" value="true" checked="checked"> <label for="remind_user">Send me a reminder </label>
				<div class="clear"></div>
				<input type="checkbox" id="remind_prospect" class="cursor-pt" name="remind_prospect" class="cursor-pt" value="true"> <label for="remind_prospect">Send {$lead->first_name} a reminder</label>

				<input type="submit" class="btn bnt-inline first" value="Create Appointment">
			</form>
		</div>
  </body>
</html>
