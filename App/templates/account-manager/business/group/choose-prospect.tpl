{extends file="layouts/business-manager-core.tpl"}

{block name="bm-head"}

{/block}

{block name="bm-body"}
	{include file="includes/navigation/communication-sub-menu.tpl"}
	<div class="con-cnt-xxlrg first inner-pad-med">
		<h3>Choose a Lead</h3>
		<span>or <a class="link" href="{$HOME}account-manager/business/add-lead">create a new one</a></span>
		<div class="clear"></div>
		<!-- <input type="search" class="inp field-med first last" placeholder="Search">
		<div class="clear"></div> -->
		{if $leads|@count < 1}
		<p class="text-sml first">No prospects available to add to this group</p>
		{/if}
		{foreach from=$leads item=lead}
			<form method="post" action="">
				<input type="hidden" name="token" value="{$csrf_token}">
				<input type="hidden" name="prospect_id" value="{$lead->id}">
				<button class="lead-tag first mat-hov cursor-pt">
					<div class="lead-icon-container floatleft">
					{if $lead->type == "trial"}
						<span class="lead-icon icon-c-3"><i class="fa fa-calendar" aria-hidden="true"></i></span>
					{elseif $lead->type == "lead"}
						{if $lead->times_contacted < 1}
						<span class="lead-icon icon-c-2"><i class="fa fa-exclamation" aria-hidden="true"></i></span>
						{else}
						<span class="lead-icon {cycle values="icon-c-1,icon-c-2,icon-c-3,icon-c-4"}">{$lead->first_name|substr:0:1|upper}</span>
						{/if}
					{/if}
					</div>
					<div class="lead-data floatleft">
						<p class="lead-name">{$lead->first_name|capitalize|truncate:20:"..."} {$lead->last_name|capitalize|truncate:20:"..."}</p>
						<p>{$lead->phone_number}</p>
						<p>{$lead->email|lower|truncate:20:"..."}</p>
					</div>
					<div class="clear"></div>
				</button>
			</form>
			<div class="clear"></div>
		{/foreach}
	</div>
{/block}
