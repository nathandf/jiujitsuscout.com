<!DOCTYPE html>
<html>
	<head>
		 {include file="includes/head/account-manager-head.tpl"}
		 <link rel="stylesheet" href="{$HOME}public/css/campaigns.css">
		 <link rel="stylesheet" href="{$HOME}public/css/leads.css">
	</head>
	<body>
		{include file="includes/navigation/business-manager-login-menu.tpl"}
		{include file="includes/navigation/business-manager-marketing-menu.tpl"}
		<div>
			<div class="clear"></div>
			<div class="con con-cnt-xlrg first inner-pad-med">
				<h2 class="first">Campaigns</h2>
				<p class="text-sml first">Start a lead generation campaign with the martial arts marketing professionals of JiuJitsuScout!</p>
				<div class="hr-sml"></div>
				<div class="clear"></div>
				<a href="{$HOME}account-manager/business/campaign/choose-campaign-type" class="btn btn-inline mat-hov first"><span class="text-med">Order a Campaign <i class="fa fa-plus" aria-hidden="true"></i></span></a>
				<div class="clear"></div>
				{if $campaigns}
					{foreach from=$campaigns item=campaign}
					<a style="padding-left: 10px;" href="{$HOME}account-manager/business/campaign/{$campaign->id}/" id="campaign{$campaign->id}" class="lead-tag first mat-hov">
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
			<div>
		</div><!-- end content -->
	</body>
</html>
