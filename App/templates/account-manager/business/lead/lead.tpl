<!DOCTYPE html>
<html>
	<head>
		{include file="includes/head/account-manager-head.tpl"}
		<link type="text/css" rel="stylesheet" href="{$HOME}public/css/partner-lead.css">
		<script rel="text/javascript" src="{$HOME}{$JS_SCRIPTS}lead.js"></script>
		<script rel="text/javascript" src="{$HOME}{$JS_SCRIPTS}sms-convo-box.js"></script>
	</head>
	<body>
		{include file="includes/navigation/business-manager-login-menu.tpl"}
		{include file="includes/navigation/business-manager-menu.tpl"}
		<div id="content">
			{include file='includes/modals/lead-info.tpl'}
			{include file='includes/modals/quick-email.tpl'}
			<div class="clear"></div>
			<div class="con con-cnt-xlrg inner-pad-med">
				<a class="btn btn-inline bg-salmon text-med" href="{$HOME}account-manager/business/leads">< Leads</a>
				<div class="clear"></div>
				<div class="contact_display">
					{if !empty($flash_messages)}
						{foreach from=$flash_messages item=message}
							<div class="con-message-success mat-hov cursor-pt --c-hide">
								<p class="user-message-body">{$message}</p>
							</div>
						{/foreach}
					{/if}
					<a href="{$HOME}account-manager/business/lead/{$lead->id}/edit" class="link tc-deep-blue text-lrg"><b>{$lead->first_name|capitalize} {$lead->last_name|capitalize}</b></a>
					<p class="text-med"><b>Number: </b>{$lead->phone_number|default:"N/a"}</p>
					<p class="text-med"><b>Email: </b>{$lead->email|default:"N/a"}</p>
					<p class="text-med"><b>Source: </b>{$lead->source|capitalize|default:"N/a"}</p>
					<p class="text-med"><b>Created At: </b>{$lead->datetime_of_action|capitalize|default:"N/a"}</p>
					<div class="clear last"></div>
					{if $lead->type == "trial"}
					<a class="link tc-mango text-med" href="{$HOME}account-manager/business/lead/{$lead->id}/trial"><span class="action-btn-text"><b>On Trial</b></span><i class="fa fa-calendar" aria-hidden="true"></i></a>
					<div class="clear"></div>
					{/if}
					{if $appointments|@count > 0}
					<a class="link tc-lavender text-med" href="{$HOME}account-manager/business/lead/{$lead->id}/appointments"><span class="action-btn-text"><b>Appointments</b></span><i class="fa fa-clock-o" aria-hidden="true"></i></a>
					<div class="clear"></div>
					{/if}
					<a class="link tc-deep-blue text-med" href="{$HOME}account-manager/business/lead/{$lead->id}/groups"><span class="action-btn-text"><b>Groups</b></span><i class="fa fa-user-o" aria-hidden="true"></i></a>
					<p class="text-sml tc-gun-metal">
					{foreach from=$groups item=group name=group_loop}
					{$group->name|truncate:30:"..."}{if $smarty.foreach.group_loop.iteration < $groups|@count}, {/if}
					{/foreach}
					</p>
					<div class="clear"></div>
					<p class="section-title-outer">Interactions: <b>{$lead->times_contacted}</b></p>
				</div>
				<div class="clear"></div>
				{if isset($sms_messages)}
				<button id="send-sms" class="btn btn-inline message-btn"><span class="action-btn-text">Send Text</span><i class="fa fa-comments-o" aria-hidden="true"></i></button>
				{/if}
				<button id="send-email" class="btn btn-inline message-btn"><span class="action-btn-text">Send Email</span><i class="fa fa-envelope-o" aria-hidden="true"></i></button>
				<div class="clear"></div>
				<form class="inline-form" action="{$HOME}account-manager/business/appointment/schedule">
					<input type="hidden" name="prospect_id" value="{$lead->id}">
					<button id="new-appointment" class="btn btn-inline message-btn texted"><span class="action-btn-text">New Appointment</span><i class="fa fa-clock-o" aria-hidden="true"></i></button>
				</form>
				{if $lead->type == "lead"}
				<form class="inline-form" action="{$HOME}account-manager/business/trial/details">
					<input type="hidden" name="prospect_id" value="{$lead->id}">
					<button id="new-trial" class="btn btn-inline message-btn emailed"><span class="action-btn-text">Start New Trial</span><i class="fa fa-calendar" aria-hidden="true"></i></button>
				</form>
				{/if}
				{if $lead->status != "lost"}
				<form class="inline-form" action="{$HOME}account-manager/business/member/convert-prospect">
					<input type="hidden" name="token" value="{$csrf_token}">
					<input type="hidden" name="prospect_id" value="{$lead->id}">
					<button id="became-member" class="btn btn-inline bg-forest message-btn --c-mp-confirm"><span class="action-btn-text">Became Member</span><i class="fa fa-usd" aria-hidden="true"></i></button>
				</form>
				<form class="inline-form" method="post" action="">
					<input type="hidden" name="token" value="{$csrf_token}">
					<input type="hidden" name="prospect_id" value="{$lead->id}">
					<input type="hidden" name="update_status" value="lost">
					<button id="lost" class="btn btn-inline notice-bg message-btn --c-status-confirm"><span class="action-btn-text">Lost / Refused</span><i class="fa fa-usd" aria-hidden="true"></i></button>
				</form>
				{/if}
				{if !empty($error_messages.record_interaction)}
					{foreach from=$error_messages.record_interaction item=message}
						<div class="con-message-failure mat-hov cursor-pt --c-hide">
							<p class="user-message-body">{$message}</p>
						</div>
					{/foreach}
				{/if}
				<form method="post" action="#note">
					<p class="descriptions floatleft">Record an interaction</p>
					<div class="clear"></div>
					<input type="hidden" name="token" value="{$csrf_token}">
					<button type="submit" name="record_interaction" value="call" class="btn btn-inline floatleft bg-dark-mint push-r">+1 Call</button>
					<button type="submit" name="record_interaction" value="text" class="btn btn-inline floatleft bg-lavender push-r">+1 Text</button>
					<button type="submit" name="record_interaction" value="voicemail" class="btn btn-inline floatleft bg-salmon push-r">+1 Voicemail</button>
					<button type="submit" name="record_interaction" value="email" class="btn btn-inline floatleft bg-mango push-r">+1 Email</button>
				</form>
				<div class="clear"></div>
				{if !empty($error_messages.add_note)}
					{foreach from=$error_messages.add_note item=message}
						<div class="con-message-failure mat-hov cursor-pt --c-hide">
							<p class="user-message-body">{$message}</p>
						</div>
					{/foreach}
				{/if}
				<form id="note" method="post" action="#note">
					<input type="hidden" name="token" value="{$csrf_token}">
					<input type="hidden" name="add_note" value="{$csrf_token}">
					<textarea class="notes first" name="body" placeholder="Write a new note for {$lead->first_name|default:"this lead"}">{$inputs.add_note.note_body|default:null}</textarea>
					<div class="clear"></div>
					<button type="submit" name="add-note" value="post" class="btn btn-inline floatleft push-r first">Save Note</button>
					<div class="clear"></div>
				</form>

				<div class="clear"></div>
				<div id="notes">
					{foreach from=$notes item=note}
					<div class="note-tag">
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
