<!DOCTYPE html>
<html>
	<head>
		{include file="includes/head/account-manager-head.tpl"}
		<link rel="stylesheet" type="text/css" href="{$HOME}css/partner-settings.css"/>
	</head>
	<body>
		{include file="includes/navigation/account-manager-login-menu.tpl"}
	    {include file="includes/navigation/account-manager-menu.tpl"}
		<div class="con-cnt-xxlrg inner-box first">
			<div class="bg-green">
		      <div class="col col-3"><p class="col-title tc-white">Account Type</p></div>
		      <div class="col col-3"><p class="col-title tc-white">Businesses</p></div>
		      <div class="col col-3-last"><p class="col-title tc-white">Users</p></div>
			<div class="clear"></div>
			</div>
	      <div class="row-seperator"></div>
	      <div class="col col-3"><p class="col-title">{$account_type->name|capitalize}{if $account_type->id == 1}<br><a class="link text-sml tc-mango" target="_blank" href="{$HOME}account-manager/upgrade"><b>Upgrade</b></a>{/if}</p></div>
	      <div class="col col-3"><p class="col-title">{$businesses|@count}</p></div>
	      <div class="col col-3-last"><p class="col-title">{$total_users}<br><b class="text-sml-heavy">max users: {if $account_type->max_users > 998}Unlimited{else}{$account_type->max_users}{/if}</b></p></div>
	      <div class="clear"></div>
		</div>
		<h2 class="title-wrapper">Businesses</h2>
		<div class="con-cnt-xxlrg encapsulate first">
			{foreach from=$businesses item=business name=businesses}
			<div class="col col-4{if $smarty.foreach.businesses.iteration % 4 == 0}-last{/if}">
				<form id="business{$smarty.foreach.businesses.index}" method="post" action="">
					<input type="hidden" name="token" value="{$csrf_token}">
					<input type="hidden" name="business_id" value="{$business->id}">
					<p class="text-med push-b first tc-forest"><b>{$business->business_name}</b></p>
					<input type="image" class="mat-hov last bg-white" style="width: 100px; box-sizing: border-box; border: 1px solid #CCC;" src="{$HOME}img/{if $business->logo_filename}uploads/{$business->logo_filename}{else}jjslogoiconblack.jpg{/if}" form="business{$smarty.foreach.businesses.index}">
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
