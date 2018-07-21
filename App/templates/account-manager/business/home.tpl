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
	    <div class="con-cnt-xxlrg">
			<table cellspacing="0" class="con-cnt-xxlrg push-t-med push-b-med">
				<tr class="bg-green">
					<th class="tc-white">Account Type</td>
					<th class="tc-white">Leads</td>
					<th class="tc-white">Listing Type</td>
				</tr>
				<tr class="bg-white">
					<td class="text-center">{$account_type->name|capitalize}{if $account_type->id != 4}<br><a class="link text-sml tc-mango" target="_blank" href="{$HOME}account-manager/upgrade"><b>Upgrade</b></a>{/if}</p></td>
					<td class="text-center">{$leads|@count}</td>
					<td class="text-center">{if $account_type->id != 1}Updgraded{else}Free{/if}</td>
				</tr>
			</table>
			<div class="con-half-min-320 cnt-640 floatleft">
				<p class="text-center text-xlrg-heavy push-b-med push-t-med">Lead Management</p>
				<a href="{$HOME}account-manager/business/leads" class="f-lvl funnel-level-1 funnel-bg-2 mat-hov">Leads<br>{$leads|@count}</a>
				<a href="{$HOME}account-manager/business/appointments" class="f-lvl funnel-level-2 funnel-bg-5 mat-hov">Appointments<br>{$appointments|@count}</a>
				<a href="{$HOME}account-manager/business/trials" class="f-lvl funnel-level-3 funnel-bg-3 mat-hov">Trials<br>{$trials|@count}</a>
				<a href="{$HOME}account-manager/business/members" class="f-lvl funnel-level-4 funnel-level-last mat-hov">Members<br>{$members|@count}</a>
	        </div>
			<div class="con-half-min-320 cnt-640 floatleft">
				<p class="text-center text-xlrg-heavy push-b-med push-t-med">Marketing Management</p>
				<div class="con-cnt-fit">
					<a href="{$HOME}account-manager/business/landing-pages/" class="btn btn-inline bg-deep-blue push-r">Landing Pages</a>
					<a href="{$HOME}account-manager/business/groups/" class="btn btn-inline bg-deep-blue push-r">Groups</a>
					<a href="{$HOME}account-manager/business/campaigns/" class="btn btn-inline bg-deep-blue">Campaigns</a>
				</div>
			</div>
			<div class="clear"></div>
		</div>
	</body>
</html>
