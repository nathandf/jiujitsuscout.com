{extends file="layouts/business-manager-core.tpl"}

{block name="bm-head"}
	<link rel="stylesheet" type="text/css" href="{$HOME}public/css/sequence.css">
	<script src="{$HOME}{$JS_SCRIPTS}add-event.js" type="text/javascript"></script>
{/block}

{block name="bm-body"}
	{include file="includes/navigation/marketing-sub-menu.tpl"}
	<div class="clear"></div>
	<div>
		<div class="clear"></div>
		<div class="con con-cnt-xlrg push-t-med inner-pad-med">
			<form id="add-event-form" method="post" action="{$HOME}account-manager/business/sequence/{$sequence->id}/add-event">
				<input type="hidden" name="add_event" value="{$csrf_token}">
				<input type="hidden" name="token" value="{$csrf_token}">
				<input id="event-type-id" type="hidden" name="event_type_id">
				<input id="template-id-input" type="hidden" name="template_id">
				<input type="hidden" name="add_another_event" value="false">
				<input type="hidden" name="duration" value="0">
			</form>
			<a class="btn btn-inline bg-deep-blue text-med push-b-med" href="{$HOME}account-manager/business/sequence/{$sequence->id}/">< Back</a>
			{if !empty($error_messages.update_sequence)}
				{foreach from=$error_messages.add_event item=message}
					<div class="con-message-failure mat-hov cursor-pt --c-hide">
						<p class="user-message-body">{$message}</p>
					</div>
				{/foreach}
			{/if}
			{include file="includes/snippets/flash-messages.tpl"}
			<div id="event-buttons-container">
			{foreach from=$eventTypes item=eventType}
				{if $eventType->id != 3}
					<button id="event-type-{$eventType->id}" class="btn btn-inline" value="{$eventType->id}"><span class="push-r-sml">{$eventType->name|capitalize} Event</span><i class="fa fa-plus-circle" aria-hidden="true"></i></button>
				{/if}
			{/foreach}
			</div>
			<div id="email-templates-container" style="display: none;">
				<p class="push-t-med">Choose the email you would like to send</p>
				{foreach from=$emailTemplates item=$emailTemplate}
				<div class="event-type-tag">
					<div class="event-type-tag-body floatleft">
						<p class="text-lrg-heavy">{$emailTemplate->name}</p>
						<p class="text-sml">{$emailTemplate->description}</p>
					</div>
					<div class="clear"></div>
					<div class="hr-sml"></div>
					<p class="text-sml-heavy">Subject:</p>
					<p class="text-med">{$emailTemplate->subject}</p>
					<p class="text-sml-heavy push-t-med">Body:</p>
					<p class="text-med">{$emailTemplate->description}</p>
					<button data-template_id="{$emailTemplate->id}" class="template-button btn btn-inline floatright push-t-med push-r-sml bg-algae tc-white">Choose Email</button>
					<div class="clear"></div>
				</div>
				<div class="clear"></div>
				{/foreach}
			</div>
			<div id="text-message-templates-container" style="display: none;">
				<p class="push-t-med">Choose the text message you would like to send</p>
				{foreach from=$textMessageTemplates item=$textMessageTemplate}
				<div class="event-type-tag">
					<div class="event-type-tag-body floatleft">
						<p class="text-lrg-heavy">{$textMessageTemplate->name}</p>
						<p class="text-sml">{$textMessageTemplate->description}</p>
					</div>
					<div class="clear"></div>
					<div class="hr-sml"></div>
					<p class="text-sml-heavy push-t-med">Message:</p>
					<p class="text-med">{$textMessageTemplate->description}</p>
					<button data-template_id="{$textMessageTemplate->id}" class="template-button btn btn-inline floatright push-t-med push-r-sml bg-algae tc-white">Choose Text Message</button>
					<div class="clear"></div>
				</div>
				<div class="clear"></div>
				{/foreach}
			</div>
		</div>
	</div><!-- end content -->
{/block}
