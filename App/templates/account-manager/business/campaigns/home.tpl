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
			<p class="text-sml">Start a lead generation campaign with the martial arts marketing professionals of JiuJitsuScout!</p>
			<div class="hr-sml"></div>
			<div class="clear"></div>
			<a href="{$HOME}account-manager/business/campaign/choose-campaign-type" class="btn btn-inline mat-hov push-t-med"><i class="fa fa-plus push-r-sml" aria-hidden="true"></i><span class="text-med">Order a Campaign</span></a>
			<div class="clear push-t-med"></div>
			{foreach from=$campaigns item=campaign}
			<a href="{$HOME}account-manager/business/campaign/{$campaign->id}/" class="tag-link">
				<div class="tag mat-hov cursor-pt">
					<div class="bg-good-green tc-white floatleft push-r-sml" style="border-radius: 3px; box-sizing: border-box; padding: 8px;">
						<i aria-hidden="true" class="fa fa-usd"></i>
					</div>
					<div class="floatleft">
						<p class="text-med-heavy">{$campaign->name|capitalize|truncate:50:"..."}</p>
						<p class="text-med">{if $campaign->description}{$campaign->description|truncate:75:"..."}{else}Description: N/a{/if}</p>
					</div>
					<div class="clear"></div>
				</div>
			</a>
			<div class="clear push-b-med"></div>
			{foreachelse}
			<p>No campaigns to show</p>
			{/foreach}
		</div>
	</div><!-- end content -->
{/block}
