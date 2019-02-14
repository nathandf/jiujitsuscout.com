{extends file="layouts/account-manager-core.tpl"}

{block name="am-head"}
	<link rel="stylesheet" type="text/css" href="{$HOME}public/css/partner-settings.css"/>
{/block}

{block name="am-body"}
	{include file="includes/navigation/account-manager-login-menu.tpl"}
	{include file="includes/navigation/account-manager-menu.tpl"}
	<div class="con-cnt-xxlrg push-t-med bg-white mat-box-shadow">
		{include file="includes/navigation/account-manager-settings-menu.tpl"}
		<div class="inner-pad-med">
			<h2 class="h2">User Management</h2>
			{include file="includes/snippets/flash-messages.tpl"}
			<p class="push-t-med">
				<span class="text-sml">Max Users: </span>
				{if $account_type->max_users > 998}
					Unlimted
				{else}
					{$account_type->max_users}
					 <!-- - <a class="link text-med tc-mango" href="{$HOME}account-manager/upgrade"><b>Extend User Limit</b></a> -->
				{/if}
			</p>
			{if $users|@count < $account_type->max_users}
			<a href="{$HOME}account-manager/settings/add-user" class="btn btn-inline leads push-t-med mat-hov"><span class="text-med">Add User <i class="fa fa-plus" aria-hidden="true"></i></span></a>
			{/if}
			<div class="clear"></div>
			{foreach from=$users item=_user}
			<a href="{$HOME}account-manager/settings/user/{$_user->id}/" class="tag-link">
				<div class="tag mat-hov cursor-pt">
					<div class="bg-salmon tc-white floatleft push-r-sml" style="border-radius: 3px; box-sizing: border-box; padding: 8px;">
						<i aria-hidden="true" class="fa fa-user-o"></i>
					</div>
					<div class="floatleft push-r-sml">
						<table>
							<tr>
								<td><p class="text-med-heavy push-r-med">{$_user->getFullName()|truncate:30:"..."}</p></td>
								<td><p class="text-med-heavy push-r-med">{$_user->role|ucfirst}</p></td>
							</tr>
						</table>
					</div>
					<div class="clear"></div>
				</div>
			</a>
			<div class="clear push-b-med"></div>
			{/foreach}
			<div class="clear"></div>
		</div>
	</div>
	<div class="clear"></div>
{/block}
