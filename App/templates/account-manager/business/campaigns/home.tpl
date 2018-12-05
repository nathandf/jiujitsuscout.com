{extends file="layouts/business-manager-core.tpl"}

{block name="bm-head"}
	<link rel="stylesheet" href="{$HOME}public/css/campaigns.css">
	<link rel="stylesheet" href="{$HOME}public/css/leads.css">
{/block}

{block name="bm-body"}
	{include file="includes/navigation/marketing-sub-menu.tpl"}
	<div>
		<div class="clear"></div>
		<div class="con con-cnt-xlrg push-t-med inner-pad-med">
			<h2 class="">Campaigns</h2>
			<p class="text-sml push-t-med">Start a lead generation campaign with the martial arts marketing professionals of JiuJitsuScout!</p>
			<div class="hr-sml"></div>
			<div class="clear"></div>
			<a href="{$HOME}account-manager/business/campaign/choose-campaign-type" class="btn btn-inline mat-hov push-t-med"><span class="text-med">Order a Campaign <i class="fa fa-plus" aria-hidden="true"></i></span></a>
			<div class="clear"></div>
			{if $campaigns}
				{foreach from=$campaigns item=campaign}
				<a style="padding-left: 10px;" href="{$HOME}account-manager/business/campaign/{$campaign->id}/" id="campaign{$campaign->id}" class="lead-tag push-t-med mat-hov">
					<img src="{$HOME}public/img/{$campaign->campaign_type->logo_filename}" alt="{$campaign->campaign_type->name}" class="img-xsml push-r floatleft">
					<div class="lead-data">
						<p class="lead-name">{$campaign->name|capitalize|truncate:50:"..."}</p>
						<p class="push-t">{if $campaign->description}{$campaign->description|truncate:75:"..."}{else}Description: N/a{/if}</p>
						<div class="hr-std push-t push-b"></div>
						<p><b>Start Date:</b></p>
						<p>{$campaign->start_date|date_format:"%a, %b %e %Y"}</p>
						<p><b>End Date:</b></p>
						<p>{$campaign->end_date|date_format:"%a, %b %e %Y"}</p>
					</div>
				</a>
				<div class="clear last"></div>
				{/foreach}
			{else}
			<p>No campaigns to show</p>
			{/if}
		</div>
	</div><!-- end content -->
{/block}
