<!DOCTYPE html>
<html>
<head>
	{include file="includes/head/account-manager-head.tpl"}
	<link rel="stylesheet" type="text/css" href="{$HOME}css/landing-pages.css">
	<link rel="stylesheet" type="text/css" href="{$HOME}css/account-manager-main.css">
	<script src="{$HOME}{$JS_SCRIPTS}site-slug-updater.js" type="text/javascript"></script>
</head>
<body>
{include file="includes/navigation/business-manager-login-menu.tpl"}
{include file="includes/navigation/business-manager-marketing-menu.tpl"}
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
		<div>
		</div><!-- end content -->
</body>
</html>
