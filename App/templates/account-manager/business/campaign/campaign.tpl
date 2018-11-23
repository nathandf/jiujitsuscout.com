{extends file="layouts/business-manager-core.tpl"}

{block name="bm-head"}

{/block}
	<link rel="stylesheet" type="text/css" href="{$HOME}public/css/landing-pages.css">
	<script src="{$HOME}{$JS_SCRIPTS}site-slug-updater.js" type="text/javascript"></script>
{block name="bm-body"}
	{include file="includes/navigation/marketing-sub-menu.tpl"}
	<div>
		<div class="clear"></div>
		<div class="con con-cnt-xlrg first inner-pad-med">
			<a class="btn btn-inline bg-deep-blue text-med last" href="{$HOME}account-manager/business/campaigns/">< Campaigns</a>
			<div class="clear first"></div>
			<p><b>Campaign Name:</b> {$campaign->name}</p>
			<div class="clear first"></div>
			<b>Description: </b>
			<div class="clear"></div>
			<p>{$campaign->description}</p>
		</div>
	</div><!-- end content -->
{/block}
