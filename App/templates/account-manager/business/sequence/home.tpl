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
			<a class="tc-deep-blue link text-med-heavy push-b-med" href="{$HOME}account-manager/business/sequences/">Sequences</a> > <span class="text-med-heavy">{$sequence->name}</span>
			<div class="hr-sml"></div>
			{include file="includes/snippets/flash-messages.tpl"}
			<a class="btn btn-inline bg-algae text-med push-b-med push-t-med" href="{$HOME}account-manager/business/sequence/{$sequence->id}/add-event">Add Events +</a>
			<a class="btn btn-inline bg-deep-blue text-med push-b-med push-t-med" href="{$HOME}account-manager/business/sequence/{$sequence->id}/edit">Edit Sequence</a>
			<div class="clear"></div>
			{foreach from=$events item=event name="event_loop"}
				<div class="event-container push-t-sml">
					<div class="event">
						<div class="floatleft event-number-container">
							<p class="event-number{if $smarty.foreach.event_loop.iteration > 9}-dd{/if}">{$event->placement}</p>
						</div>
						{if $event->event_type_id == 1}
						<i class="bg-mango event-icon fa fa-envelope" aria-hidden="true"></i>
						<div class="col-100 push-t-sml push-b-sml" style="border-top: 1px solid #CCCCCC;"></div>
						{elseif $event->event_type_id == 2}
						<i class="bg-lavender event-icon fa fa-comments-o" aria-hidden="true"></i>
						<div class="col-100 push-t-sml push-b-sml" style="border-top: 1px solid #CCCCCC;"></div>
						{elseif $event->event_type_id == 3}
						<i class="bg-deep-blue event-icon fa fa-clock-o" aria-hidden="true"></i>
						{/if}
						<p>{$event->template->name}</p>
						<p>{$event->template->description}</p>
						<div class="col-100 push-t-sml push-b-sml" style="border-top: 1px solid #CCCCCC;"></div>
						<p class="bg-deep-blue tc-white wait">
							{if $event->wait_duration|@count > 0}
							<i class="fa fa-clock-o push-l-sml push-r-sml" aria-hidden="true"></i>
							{else}
							<i class="fa fa-clock-o push-l-sml push-r-sml" aria-hidden="true"></i>
							{/if}
							Wait for {if $event->wait_duration <= 86400}{$event->wait_duration/3600} Hours{elseif $event->wait_duration > 86400 && $event->wait_duration <= 2592000}{($event->wait_duration/86400)|string_format:"%.1f"} Days{elseif $event->wait_duration > 2592000}{($event->wait_duration/2592000)|string_format:"%.1f"} Months{/if}
						</p>
					</p>
					<div class="clear"></div>
				</div>
				<div class="clear"></div>
			{foreachelse}
			<p>-- You have not created any events for this sequence --</p>
			{/foreach}
			<div class="clear"></div>
		</div>
	</div><!-- end content -->
{/block}
