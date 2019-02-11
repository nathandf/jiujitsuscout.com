{extends file="layouts/business-manager-core.tpl"}

{block name="bm-head"}
	<link type="text/css" rel="stylesheet" href="{$HOME}public/css/partner-lead.css">
	<script rel="text/javascript" src="{$HOME}{$JS_SCRIPTS}lead.js"></script>
{/block}

{block name="bm-body"}
	{include file="includes/navigation/business-manager-sub-menu.tpl"}
	{include file="includes/widgets/emailer.tpl"}
	{include file="includes/modals/actions-lead.tpl"}
	<div class="clear"></div>
	<div class="con con-cnt-xxlrg inner-pad-med push-t-med">
		<p class="text-med-heavy"><a class="tc-deep-blue link" href="{$HOME}account-manager/business/">{$business->business_name}</a> > <a class="tc-deep-blue link" href="{$HOME}account-manager/business/leads#lead{$lead->id}">Leads</a> > {$lead->getFullName()}</p>
		<div class="clear"></div>
		<button id="lead-actions-button" class="btn btn-inline bg-deep-blue tc-white push-t-med">+ Actions</button>
		{include file="includes/snippets/flash-messages.tpl"}
		<p class="section-title-outer push-t-sml">Interactions: <b>{$lead->times_contacted}</b></p>
		<table class="" style="border-collapse: collapse; width: 100%;">
			<tr>
				<th class="bg-deep-blue tc-white" colspan="2" style="border: 1px solid #CCC;">{$lead->getFullName()|capitalize}</th>
			</tr>
			<tr style="background: #f2f2f2;">
				<td class="text-med-heavy" style="text-align: center; border: 1px solid #CCC;">#</td>
				<td class="text-med-heavy" style="text-align: center; border: 1px solid #CCC;">Email</td>
			<tr>
			<tr>
				<td class="bg-white text-sml" style="overflow-x: hidden; text-align: center; border: 1px solid #CCC; border-bottom: 1px solid #888;">{$lead->phone_number|default:"N/a"}</td>
				<td class="bg-white text-sml" style="overflow-x: hidden; text-align: center; border: 1px solid #CCC; border-bottom: 1px solid #888;">{$lead->email|default:"N/a"}</td>
			</tr>
			<tr style="background: #f2f2f2;">
				<td class="text-med-heavy"style="text-align: center; border: 1px solid #CCC; border-top: 1px solid #888;">Source</td>
				<td class="text-med-heavy" style="text-align: center; border: 1px solid #CCC; border-top: 1px solid #888;">Date</td>
			</tr>
			<tr>
				<td class="bg-white text-sml" class="text-med" style="overflow-x: hidden; text-align: center; border: 1px solid #CCC;">{$lead->source|default:"N/a"}</td>
				<td class="bg-white text-sml" style="overflow-x: hidden; text-align: center; border: 1px solid #CCC;">{$lead->datetime_of_action|date_format:"%Y/%m/%d"|default:"N/a"}</td>
			</tr>
		</table>
		<div class="clear push-t-med"></div>
		{if $lead->type == "trial"}
		<a class="link tc-mango text-med push-r-sml" href="{$HOME}account-manager/business/lead/{$lead->id}/trial"><span class="action-btn-text">On Trial</span><i class="fa fa-calendar" aria-hidden="true"></i></a>
		{/if}
		{if $appointments|@count > 0}
		<a class="link tc-lavender text-med push-r-sml" href="{$HOME}account-manager/business/lead/{$lead->id}/appointments"><span class="action-btn-text">Appointments</span><i class="fa fa-clock-o" aria-hidden="true"></i></a>
		{/if}
		<a class="link tc-deep-blue text-med" href="{$HOME}account-manager/business/lead/{$lead->id}/groups"><span class="action-btn-text">Groups</span><i class="fa fa-users" aria-hidden="true"></i></a>
		<p class="text-sml tc-gun-metal">
		{foreach from=$groups item=group name=group_loop}
		{$group->name|truncate:30:"..."}{if $smarty.foreach.group_loop.iteration < $groups|@count}, {/if}
		{/foreach}
		</p>
		<div class="clear push-t-med"></div>
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
			<label for="" class="text-med">Write a new note for {$lead->getFullName()|default:"this lead"}</label>
			<div class="clear"></div>
			<textarea class="notes" name="body" placeholder="{$lead->getFullName()|default:"this lead"} will not see this note">{$inputs.add_note.note_body|default:null}</textarea>
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
					<button type="submit" class="bg-white floatright"><p class="text-lrg-heavy link tc-red"><i class="fa fa-trash" aria-hidden="true"></i></p></button>
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
{/block}
