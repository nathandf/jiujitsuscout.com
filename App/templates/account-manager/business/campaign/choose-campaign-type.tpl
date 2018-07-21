<!DOCTYPE html>
<html>
	<head>
		 {include file="includes/head/account-manager-head.tpl"}
		 <link rel="stylesheet" type="text/css" href="{$HOME}public/css/campaigns.css">
		 <link rel="stylesheet" type="text/css" href="{$HOME}public/css/account-manager-main.css">
		 <script src="{$HOME}{$JS_SCRIPTS}site-slug-updater.js" type="text/javascript"></script>
	</head>
	<body>
		{include file="includes/navigation/business-manager-login-menu.tpl"}
		{include file="includes/navigation/business-manager-marketing-menu.tpl"}
		<div>
			<div class="clear"></div>
			<div class="con con-cnt-xlrg first inner-pad-med">
				<h2 class="first last">Choose Campaign Type</h2>
				{foreach from=$campaign_types item=campaign_type}
				<div class="campaign-tag-container">
					<a href="{$HOME}account-manager/business/campaign/new?campaign_type_id={$campaign_type->id}" class="campaign-tag mat-hov cursor-pt first push-r">
						<img src="{$HOME}public/img/{$campaign_type->logo_filename}" alt="{$campaign_type->name}" class="campaign-tag-img floatleft">
					</a>
					<div class="campaign-tag-text">
						<p class="text-med">{$campaign_type->description}</p>
					</div>
					<div class="clear"></div>
				</div>
				<div class="clear"></div>
				{/foreach}
			<div>
		</div><!-- end content -->
	</body>
</html>
