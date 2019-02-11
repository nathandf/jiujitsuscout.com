{extends file="layouts/business-manager-core.tpl"}

{block name="bm-head"}
	<link rel="stylesheet" type="text/css" href="{$HOME}public/css/landing-pages.css">
	<script src="{$HOME}{$JS_SCRIPTS}site-slug-updater.js" type="text/javascript"></script>
{/block}

{block name="bm-body"}
	{include file="includes/navigation/marketing-sub-menu.tpl"}
	<div>
		<div class="clear"></div>
		<div class="con con-cnt-xlrg push-t-med inner-pad-med">
			<a class="btn btn-inline bg-deep-blue text-med last" href="{$HOME}account-manager/business/campaigns/">< All Campaigns</a>
			{if !empty($error_messages.create_campaign)}
				{foreach from=$error_messages.create_campaign item=message}
					<div class="con-message-failure mat-hov cursor-pt --c-hide">
						<p class="user-message-body">{$message}</p>
					</div>
				{/foreach}
			{/if}
			<form method="get" action="{$HOME}account-manager/business/campaign/new">
				<input type="hidden" name="token" value="{$csrf_token}">
				<input type="hidden" name="create_campaign" value="true">
				<div class="clear push-t-med"></div>
				<input type="hidden" name="campaign_type_id" value="{$campaign_type_id}">
				<p class="text-sml">Campaign Name</p>
				<input type="text" name="name" value="{$inputs.create_campaign.name|default:null}" class="inp inp-med-plus-plus" placeholder="Campaign name">
				<div class="clear push-t-med"></div>
				<p class="text-sml">Description:</p>
				<div class="clear"></div>
				<textarea style="text-indent: 0px; padding: 8px;" name="description" class="inp textarea" id="" cols="30" rows="10" placeholder="Campaign Description">{$inputs.create_campaign.description|default:null}</textarea>
				<div class="clear push-t-med"></div>
				<p class="text-sml">Start Date:</p>
				{html_select_date class="inp inp-sml cursor-pt" prefix='start' start_year='-1' end_year='+3'}
				<div class="clear"></div>
				<p class="text-sml push-t-sml">End Date:</p>
				{html_select_date class="inp inp-sml cursor-pt"  prefix='end' start_year='-1' end_year='+3'}
				<div class="clear"></div>
				<input type="submit" class="btn btn-inline push-t-med" value="Create campaign">
			</form>
		<div>
	</div><!-- end content -->
{/block}
