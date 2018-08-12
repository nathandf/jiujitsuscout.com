<!DOCTYPE html>
<html>
	<head>
		{include file="includes/head/account-manager-head.tpl"}
		<link rel="stylesheet" type="text/css" href="{$HOME}public/css/partner-settings.css"/>
	</head>
	<body>
		{include file="includes/navigation/account-manager-login-menu.tpl"}
	    {include file="includes/navigation/account-manager-menu.tpl"}
		<table cellspacing="0" class="con-cnt-xxlrg push-t-med push-b-med">
			<tr class="bg-green">
				<th class="tc-white">Account</td>
				<th class="tc-white">Businesses</td>
				<th class="tc-white">Users</td>
			</tr>
			<tr class="bg-white">
				<td class="text-center">
					{$account_type->name|capitalize}
					{if $user->role|in_array:[ "owner", "administrator"]}
						{if $account_type->id != 4}
							<br>
							<a class="link text-sml tc-mango" target="_blank" href="{$HOME}account-manager/upgrade">
								<b>Upgrade</b>
							</a>
						{/if}
					{/if}
				</td>
				<td class="text-center">{$businesses|@count}</td>
				<td class="text-center">{$total_users}<br><b class="text-sml-heavy">max users: {if $account_type->max_users > 998}Unlimited{else}{$account_type->max_users}{/if}</b></p></td>
			</tr>
		</table>

		<h2 class="title-wrapper push-t-med">Businesses</h2>
		<div class="con-cnt-xxlrg encapsulate first">
			{foreach from=$businesses item=business name=businesses}
			<div class="col col-4{if $smarty.foreach.businesses.iteration % 4 == 0}-last{/if}">
				<form id="business{$smarty.foreach.businesses.index}" method="post" action="">
					<input type="hidden" name="token" value="{$csrf_token}">
					<input type="hidden" name="business_id" value="{$business->id}">
					<p class="text-med push-b first tc-forest"><b>{$business->business_name}</b></p>
					<input type="image" class="mat-hov last bg-white" style="width: 100px; box-sizing: border-box; border: 1px solid #CCC;" src="{$HOME}public/img/{if $business->logo_filename}uploads/{$business->logo_filename}{else}jjslogoiconblack.jpg{/if}" form="business{$smarty.foreach.businesses.index}">
					<div class="clear last"></div>
				</form>
			</div>
			{if ( $smarty.foreach.businesses.iteration ) % 4 == 0 || $smarty.foreach.businesses.last}
				<div class="clear"></div>
			{/if}
			{/foreach}
		</div>
	</body>
</html>
