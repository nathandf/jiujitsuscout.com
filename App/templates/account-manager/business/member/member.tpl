{extends file="layouts/business-manager-core.tpl"}

{block name="bm-head"}
	<link type="text/css" rel="stylesheet" href="{$HOME}public/css/partner-lead.css">
	<script rel="text/javascript" src="{$HOME}{$JS_SCRIPTS}lead.js"></script>
{/block}

{block name="bm-body"}
	{include file="includes/navigation/business-manager-sub-menu.tpl"}
	{include file='includes/widgets/emailer.tpl'}
	<div class="con-cnt-xxlrg inner-pad-med">
		<div class="clear first"></div>
		<a class="btn btn-inline bg-dark-mint text-med" href="{$HOME}account-manager/business/members#member{$member->id}">< All Members</a>
		<div class="clear"></div>
		<div class="contact_display">
			<a href="{$HOME}account-manager/business/member/{$member->id}/edit" class="link tc-deep-blue text-lrg-heavy">{$member->first_name|capitalize} {$member->last_name|capitalize}</a>
			<p class="text-med"><b>Number: </b>{$member->phone_number|default:"N/a"}</p>
			<p class="text-med"><b>Email: </b>{$member->email|default:"N/a"}</p>
			<div class="clear first"></div>
			<a class="link tc-deep-blue text-med" href="{$HOME}account-manager/business/member/{$member->id}/groups"><span class="action-btn-text"><b>Groups</b></span><i class="fa fa-user-o" aria-hidden="true"></i></a>
			<p class="text-sml tc-gun-metal">
			{foreach from=$groups item=group name=group_loop}
			{$group->name|truncate:30:"..."}{if $smarty.foreach.group_loop.iteration < $groups|@count}, {/if}
			{/foreach}
			</p>
			<div class="clear"></div>
		</div>
		<div class="clear"></div>
		{if isset($sms_messages)}
		<button id="send-sms" class="btn btn-inline message-btn"><span class="action-btn-text">Send Text</span><i class="fa fa-comments-o" aria-hidden="true"></i></button>
		{/if}
		<button id="send-email" class="btn btn-inline emailer-open message-btn"><span class="action-btn-text">Send Email</span><i class="fa fa-envelope-o" aria-hidden="true"></i></button>
		<div class="clear"></div>
		<div>
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
				<textarea class="notes" name="body" placeholder="Type a new note for {$member->first_name}"></textarea>
				<div class="clear"></div>
				<button type="submit" name="add-note" value="post" class="btn btn-inline mat-hov">Post</button>
				<div class="clear"></div>
			</form>
		</div><!-- end post -->
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
{/block}
