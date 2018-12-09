{extends file="layouts/business-manager-core.tpl"}

{block name="bm-head"}
	<link rel="stylesheet" type="text/css" href="{$HOME}public/css/landing-pages.css">
	<script src="{$HOME}{$JS_SCRIPTS}site-slug-updater.js" type="text/javascript"></script>
{/block}

{block name="bm-body"}
	{include file="includes/navigation/marketing-sub-menu.tpl"}
	<div class="clear"></div>
	<div>
		<div class="clear"></div>
		<div class="con con-cnt-xlrg push-t-med inner-pad-med">
			<a class="btn btn-inline bg-deep-blue text-med push-b-med" href="{$HOME}account-manager/business/sequence/{$sequence->id}/">< Back</a>
			<div class="hr-sml"></div>
			{if !empty($error_messages.update_sequence)}
				{foreach from=$error_messages.add_event item=message}
					<div class="con-message-failure mat-hov cursor-pt --c-hide">
						<p class="user-message-body">{$message}</p>
					</div>
				{/foreach}
			{/if}
			{include file="includes/snippets/flash-messages.tpl"}
			<form method="post" action="{$HOME}account-manager/business/sequence/{$sequence->id}/">
				<input type="hidden" name="token" value="{$csrf_token}">
				<input type="hidden" name="add_event" value="{$csrf_token}">
				<div class="clear push-t-med"></div>
				<select class="inp field-med cursor-pt" name="event_type_id" id="">
					<option value="" hidden="true">-- Choose an Event Type --</option>
					{foreach from=$eventTypes item=eventType}
					<option value="{$eventType->id}">{$eventType->name}</option>
					{/foreach}
				</select>
			</form>
		</div>
	</div><!-- end content -->
{/block}
