{extends file="layouts/business-manager-core.tpl"}

{block name="bm-head"}
	<link type="text/css" rel="stylesheet" href="{$HOME}public/css/partner-lead.css">
	<script rel="text/javascript" src="{$HOME}{$JS_SCRIPTS}member.js"></script>
{/block}

{block name="bm-body"}
	{include file="includes/navigation/business-manager-sub-menu.tpl"}
	{include file='includes/widgets/emailer.tpl'}
	{include file="includes/modals/actions-member.tpl"}
	<div class="clear"></div>
	<div class="con con-cnt-xxlrg inner-pad-med push-t-med">
		<p class="text-med-heavy"><a class="tc-deep-blue link" href="{$HOME}account-manager/business/">{$business->business_name}</a> > <a class="tc-deep-blue link" href="{$HOME}account-manager/business/members">Members</a> > {$member->getFullName()}</p>
		<div class="clear"></div>
		<button id="member-actions-button" class="btn btn-inline bg-deep-blue tc-white push-t-med">Actions +</button>
		{include file="includes/snippets/flash-messages.tpl"}
		<table class="" style="border-collapse: collapse; width: 100%;">
			<tr>
				<th class="bg-deep-blue tc-white" colspan="2" style="border: 1px solid #CCC;">{$member->getFullName()|capitalize}</th>
			</tr>
			<tr style="background: #f2f2f2;">
				<td class="text-med-heavy" style="text-align: center; border: 1px solid #CCC;">#</td>
				<td class="text-med-heavy" style="text-align: center; border: 1px solid #CCC;">Email</td>
			<tr>
			<tr>
				<td class="bg-white text-sml" style="overflow-x: hidden; text-align: center; border: 1px solid #CCC; border-bottom: 1px solid #888;">{$member->phone_number|default:"N/a"}</td>
				<td class="bg-white text-sml" style="overflow-x: hidden; text-align: center; border: 1px solid #CCC; border-bottom: 1px solid #888;">{$member->email|default:"N/a"}</td>
			</tr>
		</table>
		<div class="clear push-t-med"></div>
		{foreach from=$groups item=group name=group_loop}
		{$group->name|truncate:30:"..."}{if $smarty.foreach.group_loop.iteration < $groups|@count}, {/if}
		{/foreach}
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
			<label for="" class="text-med">Write a new note for {$member->getFullName()|default:"this member"}</label>
			<div class="clear"></div>
			<textarea class="notes" name="body" placeholder="{$member->getFullName()|default:"this member"} will not see this note">{$inputs.add_note.note_body|default:null}</textarea>
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
	</div><!-- end member-manager-container -->
	<div class="clear"></div>
{/block}
