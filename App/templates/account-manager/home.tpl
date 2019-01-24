{extends file="layouts/account-manager-core.tpl"}

{block name="am-head"}
	<link rel="stylesheet" type="text/css" href="{$HOME}public/css/partner-settings.css"/>
{/block}

{block name="am-body"}
	{include file="includes/navigation/account-manager-login-menu.tpl"}
	{include file="includes/navigation/account-manager-menu.tpl"}
	<table cellspacing="0" class="con-cnt-xxlrg push-t-med push-b-med">
		<tr class="bg-green">
			<th class="tc-white">Credit</td>
			<th class="tc-white">Businesses</td>
			<th class="tc-white">Users</td>
		</tr>
		<tr class="bg-white">
			<!-- <td class="text-center"> -->
				{*$account_type->name|capitalize*}
				{if $user->role|in_array:[ "owner", "administrator" ]}
					{if $account_type->id != 4}
						<!-- <br>
						<a class="link text-sml tc-mango" target="_blank" href="{$HOME}account-manager/upgrade">
							<b>Upgrade</b>
						</a> -->
					{/if}
				{/if}
			<!-- </td> -->
			<td class="text-center">${$account->credit|string_format:"%.2f"}</td>
			<td class="text-center">{$businesses|@count}</td>
			<td class="text-center">{$total_users}<br><b class="text-sml-heavy">max users: {if $account_type->max_users > 998}Unlimited{else}{$account_type->max_users}{/if}</b></p></td>
		</tr>
	</table>

	<h2 class="title-wrapper push-t-med">Businesses</h2>
	<table cellspacing="0" class="con-cnt-xxlrg push-t-med push-b-med">
	{foreach from=$businesses item=business name=businesses}
		<tr style="border: 1px solid #CCC;">
			<td class="bg-white">
				<img style="height: 55px; display: block; margin: 0 auto;" src="{$HOME}public/img/{if $business->logo_filename}uploads/{$business->logo_filename}{else}jjslogoiconblack.jpg{/if}" alt="">
			</td>
			<td class="bg-white">
				<p class="text-xlrg-heavy tc-black">{$business->business_name}</p>
			</td>
			<td class="bg-white" style="padding-right: 15px;">
				<a href="{$HOME}account-manager/?business_id={$business->id}&token={$csrf_token}" class="btn bg-deep-blue text-center" style="padding: 10px; display: block; margin: 0 auto;">Access Business</a>
			</td>
		</tr>
	{/foreach}
	</table>
{/block}
