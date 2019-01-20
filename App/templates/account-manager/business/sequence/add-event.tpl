{extends file="layouts/business-manager-core.tpl"}

{block name="bm-head"}
	<link rel="stylesheet" type="text/css" href="{$HOME}public/css/sequence.css">
	<script src="{$HOME}{$JS_SCRIPTS}add-event.js" type="text/javascript"></script>
{/block}

{block name="bm-body"}
	{include file="includes/navigation/communication-sub-menu.tpl"}
	<div class="clear"></div>
	<div>
		<div class="clear"></div>
		<div class="con con-cnt-xlrg push-t-med inner-pad-med">
			<form id="add-event-form" method="post" action="{$HOME}account-manager/business/sequence/{$sequence->id}/add-event">
				<input type="hidden" name="add_event" value="{$csrf_token}">
				<input type="hidden" name="token" value="{$csrf_token}">
				<input id="event-type-id" type="hidden" name="event_type_id">
				<input id="template-id-input" type="hidden" name="template_id">
				<input id="add-wait-duration" type="hidden" name="add_wait_duration" value="false">
				<input id="wait-duration-input" type="hidden" name="wait_duration" value="0">
				<input id="wait-duration-interval-input" type="hidden" name="wait_duration_interval" value="days">
			</form>
			<a class="tc-deep-blue link text-med-heavy push-b-med" href="{$HOME}account-manager/business/sequences/">Sequences</a> > <a href="{$HOME}account-manager/business/sequence/{$sequence->id}/" class="tc-deep-blue link text-med-heavy">{$sequence->name}</a> > <span class="text-med-heavy">Add Event</span>
			<div class="hr-sml"></div>
			{if !empty($error_messages.update_sequence)}
				{foreach from=$error_messages.add_event item=message}
					<div class="con-message-failure mat-hov cursor-pt --c-hide">
						<p class="user-message-body">{$message}</p>
					</div>
				{/foreach}
			{/if}
			{include file="includes/snippets/flash-messages.tpl"}
			<div id="event-buttons-container" class="push-t-med">
			{foreach from=$eventTypes item=eventType}
				{if $eventType->id != 3}
					{if $eventType->id == 1}
					<button id="event-type-{$eventType->id}" class="btn btn-inline bg-mango" value="{$eventType->id}"><span class="push-r-sml">{$eventType->name|capitalize} Event</span><i class="fa fa-envelope" aria-hidden="true"></i></button>
					{else}
					<button id="event-type-{$eventType->id}" class="btn btn-inline bg-lavender" value="{$eventType->id}"><span class="push-r-sml">{$eventType->name|capitalize} Event</span><i class="fa fa-comments-o" aria-hidden="true"></i></button>
					{/if}
				{/if}
			{/foreach}
			</div>
			<div id="add-wait-event-container" style="display: none;">
				<p class="text-med">If no wait time is specified, the event after this one will execute immediately.</p>
				<div class="clear push-t-sml"></div>
				<input class="checkbox cursor-pt" type="checkbox" id="wait-checkbox" >
				<label for="">Add a wait time</label>
				<div id="wait-duration-container" style="display: none;">
					<div class="hr-sml"></div>
					<p class="text-med-heavy">Wait Duration</p>
					<p class="text-sml">How long to wait until the next event occurs</p>
					<input id="wait-duration" type="number" class="inp field-sml push-t-sml" placeholder="ex. 6">
					<select class="inp field-sml push-t-sml" id="wait-duration-interval">
						<option value="hours">Hours</option>
						<option value="days" selected="selected">Days</option>
						<option value="months">Months</option>
					</select>
					<div class="clear"></div>
				</div>
				<div class="clear"></div>
				<button id="finish-button" class="btn btn-inline push-t-sml">Finish</button>
				<div class="clear"></div>
			</div>
			<div id="email-templates-container"  class="event-templates-container" style="display: none;">
				{if !empty( $emailTemplates )}
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
				{else}
				<p class="push-t-med">-- No Text Messages have been created yet --</p>
				<div class="clear push-t-med"></div>
				<a class="btn btn-inline text-med-heavy bg-deep-blue" href="{$HOME}account-manager/business/text-message/new">Create a Text Message +</a>
				{/if}
			</div>
			<div id="text-message-templates-container" class="event-templates-container" style="display: none;">
				{if !empty($textMessageTemplates)}
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
				{else}
				<p class="push-t-med">-- No Text Messages have been created yet --</p>
				<div class="clear push-t-med"></div>
				<a class="btn btn-inline text-med-heavy bg-deep-blue" href="{$HOME}account-manager/business/text-message/new">Create a Text Message +</a>
				{/if}
			</div>
		</div>
	</div><!-- end content -->
{/block}
