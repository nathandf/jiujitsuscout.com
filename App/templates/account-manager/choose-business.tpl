{extends file="layouts/account-manager-core.tpl"}

{block name="am-head"}
	<link rel="stylesheet" type="text/css" href="{$HOME}public/css/partner-sign-in.css"/>
{/block}

{block name="am-body"}
	{include file="includes/navigation/account-manager-login-menu.tpl"}
	{include file="includes/navigation/account-manager-menu.tpl"}
	<div class="content">
		<div class="encapsulation-cnt-bare choose-form">
			<p class="encap-header bg-green tc-white">Businesses</p>
			<a href="{$HOME}account-manager/add-business" class="btn btn-inline first bg-deep-blue">Add a gym <i class="fa fa-plus" aria-hidden="true"></i></a>
			<div class="first">
				{if !empty($error_messages.choose_business)}
					{foreach from=$error_messages.choose_business item=message}
						<div class="con-message-failure mat-hov cursor-pt --c-hide">
							<p class="user-message-body">{$message}</p>
						</div>
					{/foreach}
				{/if}
				{foreach from=$businesses item=business name=businesses}
				<div class="clear"></div>
				<form id="business{$smarty.foreach.businesses.index}" method="post" action="">
					<input type="hidden" name="token" value="{$csrf_token}">
					<input type="hidden" name="business_id" value="{$business->id}">
					<p class="text-med push-b first tc-forest"><b>{$business->business_name}</b></p>
					<input type="image" class="mat-hov bg-white last" style="width: 100px; box-sizing: border-box; border: 1px solid #CCC;" src="{if !is_null($business->logo_image_id)}{$HOME}public/img/uploads/{$business->logo->filename}{else}http://placehold.it/300x300&text=x{/if}" form="business{$smarty.foreach.businesses.index}">
					<div class="clear last"></div>
				</form>
				{/foreach}
			</div>
		</div>
	</div>
{/block}
