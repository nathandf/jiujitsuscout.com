<!DOCTYPE html>
<html>
	<head>
		{include file="includes/head/account-manager-head.tpl"}
		<link rel="stylesheet" type="text/css" href="{$HOME}public/css/user.css"/>
		<link rel="stylesheet" type="text/css" href="{$HOME}public/css/account-manager-main.css"/>
		<script rel="text/javascript" src="{$HOME}{$JS_SCRIPTS}lead.js"></script>
	</head>
	<body>
		{include file="includes/navigation/business-manager-login-menu.tpl"}
	    {include file="includes/navigation/business-manager-menu.tpl"}
		<div style="border: 1px solid #CCC;" class="con-cnt-xxlrg settings-box push-t-med">
			{include file="includes/navigation/business-profile-menu.tpl"}
			<div class="inner-pad-lrg">
				<h2 class="h2">My Profile</h2>
				<table cellspacing="0" class="col-100 push-t-med push-b-med" style="border: 1px solid #CCC;">
					<tr class="bg-green">
						<th class="tc-white">Listing Clicks</td>
						<th class="tc-white">Leads</td>
					</tr>
					<tr class="bg-white">
						<td class="text-center">{$lisiting_clicks|@count}</td>
						<td class="text-center">--</td>
					</tr>
				</table>
			<div class="clear"></div>
		</div>
		<div class="clear"></div>
	</body>
</html>
