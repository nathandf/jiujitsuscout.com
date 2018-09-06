<!DOCTYPE html>
<html>
	<head>
		{include file="includes/head/account-manager-head.tpl"}
		<link rel="stylesheet" type="text/css" href="{$HOME}public/css/partner-settings.css"/>
	</head>
	<body>
		{include file="includes/navigation/account-manager-login-menu.tpl"}
	    {include file="includes/navigation/account-manager-menu.tpl"}
		<div class="con-cnt-xxlrg inner-box first">
			{include file="includes/navigation/account-manager-settings-menu.tpl"}
			<div class="con-cnt-xlrg">
				<div class="inner-pad-med">
					<h2 class="h2 first last">User Management</h2>
					<p class="last first">
						<span class="text-sml">Max Users: </span>
						{if $account_type->max_users > 998}
							Unlimted
						{else}
							{$account_type->max_users}
							 <!-- - <a class="link text-med tc-mango" href="{$HOME}account-manager/upgrade"><b>Extend User Limit</b></a> -->
						{/if}
					</p>
					{if $users|@count < $account_type->max_users}
					<a href="{$HOME}account-manager/settings/add-user" class="btn btn-inline leads first mat-hov"><span class="text-med">Add User <i class="fa fa-plus" aria-hidden="true"></i></span></a>
					{/if}
					<div class="clear"></div>
					{foreach from=$users item=_user}
					<div class="user-tag first">
						<div class="user-tag-icon floatleft push-r">
							<i class="fa fa-user-o" aria-hidden="true"></i>
						</div>
						<div class="user-details floatleft">
							<p class="text-med"><b>{$_user->first_name} {$_user->last_name}</b> {$_user->role|ucfirst}</p>
						</div>
						{* If current user is account owner or administrator, allow access to user edit functionality *}
						{if $user->role|in_array:[ "owner", "administrator" ]}
							<a class="tc-forest floatleft push-l text-med" href="{$HOME}account-manager/settings/user/{$_user->id}/edit"><b>Edit</b></a>
						{/if}
						<!-- <a class="tc-forest floatleft push-l text-med" href="{$HOME}account-manager/settings/user/{$_user->id}/edit"><b>Edit</b></a> -->
						<div class="clear"></div>
					</div>
					<div class="clear"></div>
					{/foreach}
					<div class="clear"></div>
				</div>
			</div>
		</div>
		<div class="clear"></div>
	</body>
</html>
