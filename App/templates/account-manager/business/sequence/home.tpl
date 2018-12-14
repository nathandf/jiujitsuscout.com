{extends file="layouts/business-manager-core.tpl"}

{block name="bm-head"}
	<link rel="stylesheet" type="text/css" href="{$HOME}public/css/sequence.css">
	<script src="{$HOME}{$JS_SCRIPTS}site-slug-updater.js" type="text/javascript"></script>
{/block}

{block name="bm-body"}
	{include file="includes/navigation/marketing-sub-menu.tpl"}
	<div class="clear"></div>
	<div>
		<div class="clear"></div>
		<div class="con con-cnt-xlrg push-t-med inner-pad-med">
			<a class="btn btn-inline bg-deep-blue text-med push-b-med" href="{$HOME}account-manager/business/sequences/">< All Sequences</a>
			<div class="hr-sml"></div>
			{include file="includes/snippets/flash-messages.tpl"}
			<a class="btn btn-inline bg-lavender text-med push-b-med push-t-med" href="{$HOME}account-manager/business/sequence/{$sequence->id}/add-event">Add Events +</a>
			<div class="clear"></div>
			{foreach from=$events item=event name="event_loop"}
				<div class="floatleft event-container push-t-sml">
					<div class="floatleft event-number-container">
						<p class="event-number">{$smarty.foreach.event_loop.iteration}</p>
					</div>
					<p class="floatleft push-r-med">
						{if $event->event_type_id == 1}
						<i class="bg-mango event mat-hov cursor-pt fa fa-2x fa-envelope" aria-hidden="true"></i>
						{elseif $event->event_type_id == 2}
						<i class="bg-lavender event mat-hov cursor-pt fa fa-2x fa-comments-o" aria-hidden="true"></i>
						{elseif $event->event_type_id == 3}
						<i class="bg-deep-blue event mat-hov cursor-pt fa fa-2x fa-clock-o" aria-hidden="true"></i>
						{/if}
					</p>
					<div class="clear"></div>
				</div>
			{foreachelse}
			<p>-- You have not created any events for this sequence --</p>
			{/foreach}
			<div class="clear"></div>
			<div class="hr-sml"></div>
			{if !empty($error_messages.update_sequence)}
				{foreach from=$error_messages.update_sequence item=message}
					<div class="con-message-failure mat-hov cursor-pt --c-hide">
						<p class="user-message-body">{$message}</p>
					</div>
				{/foreach}
			{/if}
			<form method="post" action="{$HOME}account-manager/business/sequence/{$sequence->id}/">
				<input type="hidden" name="token" value="{$csrf_token}">
				<input type="hidden" name="update_sequence" value="{$csrf_token}">
				<div class="clear push-t-med"></div>
				<p class="push-t-med"><b>Name:</b></p>
				<input style="padding: 3px;" type="text" name="name" value="{$sequence->name}" class="inp" placeholder="">
				<div class="clear push-t-med"></div>
				<p><b>Description:</b></p>
				<textarea name="description" class="inp textarea" placeholder="">{$sequence->description}</textarea>
				<div class="clear push-t-med"></div>
				<input type="submit" class="btn btn-inline" value="Update Sequence">
			</form>
		</div>
	</div><!-- end content -->
{/block}
