{extends file="layouts/business-manager-core.tpl"}

{block name="bm-head"}
	<link rel="stylesheet" type="text/css" href="{$HOME}public/css/leads.css"/>
{/block}

{block name="bm-body"}
	{include file="includes/navigation/business-manager-sub-menu.tpl"}
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
			<p class="label">Date</p>
			{html_select_date class="inp inp-sml cursor-pt push-b-med" start_year='-1' end_year='+3'}
			<div class="clear"></div>
			<p class="label">Time</p>
			{html_select_time class="inp inp-sml cursor-pt push-b-med" minute_interval=15 display_seconds=false use_24_hours=false}
			<p class="label">Reminders</p>
			<input type="checkbox" id="remind_user" class="first cursor-pt" name="remind_user" class="cursor-pt" value="true" checked="checked"> <label for="remind_user">Send me a reminder </label>
			<div class="clear"></div>
			<input type="checkbox" id="remind_prospect" class="cursor-pt" name="remind_prospect" class="cursor-pt" value="true"> <label for="remind_prospect">Send {$lead->first_name} a reminder</label>

			<input type="submit" class="btn bnt-inline first" value="Create Appointment">
		</form>
	</div>
{/block}
