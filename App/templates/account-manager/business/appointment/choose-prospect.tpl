{extends file="layouts/business-manager-core.tpl"}

{block name="bm-head"}

{/block}

{block name="bm-body"}
	{include file="includes/navigation/business-manager-sub-menu.tpl"}
	<div class="con-cnt-xxlrg push-t-med inner-pad-med">
		<h3>Choose a Lead</h3>
		<span>or <a class="link" href="{$HOME}account-manager/business/add-lead">create a new one</a></span>
		<div class="clear"></div>
		<!-- <input type="search" class="inp field-med push-t-med last" placeholder="Search">
		<div class="clear"></div> -->
		{foreach from=$leads item=lead}
			{if $lead->requires_purchase == 0}
			<a href="{$HOME}account-manager/business/appointment/schedule?prospect_id={$lead->id}" id="lead{$lead->id}">
				<div class="tag push-t-med mat-hov">
					<div class="lead-icon-container floatleft">
						<span class="lead-icon {cycle values="icon-c-1,icon-c-2,icon-c-3,icon-c-4"}">{$lead->first_name|substr:0:1|upper}</span>
					</div>
					<div class="lead-data floatleft">
						<p class="lead-name">{$lead->first_name|capitalize|truncate:20:"..."} {$lead->last_name|capitalize|truncate:20:"..."}</p>
						<p>{$lead->phone_number}</p>
						<p>{$lead->email|lower|truncate:20:"..."}</p>
					</div>
					<div class="clear"></div>
				</div>
			</a>
			{/if}
			<div class="clear"></div>
		{/foreach}
	</div>
{/block}
