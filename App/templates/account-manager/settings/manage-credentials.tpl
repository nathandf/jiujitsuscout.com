{extends file="layouts/account-manager-core.tpl"}

{block name="am-head"}
	<link rel="stylesheet" type="text/css" href="{$HOME}public/css/partner-settings.css"/>
{/block}

{block name="am-body"}
	{include file="includes/navigation/business-manager-login-menu.tpl"}
	{include file="includes/navigation/account-manager-menu.tpl"}
	<div class="con-cnt-xxlrg bg-white mat-box-shadow push-t-med">
		{include file="includes/navigation/account-manager-settings-menu.tpl"}
		<div class="inner-pad-med">
			<h2 class="h2">Change Password</h2>
			<div class="clear push-t-med"></div>
			{if !empty($error_messages.update_password)}
				{foreach from=$error_messages.update_password item=message}
					<div class="con-message-failure mat-hov cursor-pt --c-hide">
						<p class="user-message-body">{$message}</p>
					</div>
				{/foreach}
			{/if}
			<form action="" method="post" id="submit-form" >
				<input type="hidden" name="token" value="{$csrf_token}">
				<input type="hidden" name="update_password" value="{$csrf_token}">
				<input type="text" class="inp" id="email" name="email" value="{$inputs.update_password.email|default:null}" placeholder="Email" />
				<div class="clear push-t-med"></div>
				<input type="password" class="inp" id="password" name="password" placeholder="New password" />
				<div class="clear push-t-med"></div>
				<input type="password" class="inp" id="confim_password" name="confirm_password" placeholder="Confirm new password" />
				<div class="clear push-t-med"></div>
				<input type="submit" class="btn btn-inline" name="passwordReset"  value="Reset Password" color="#fff"/>
			</form>
		</div>
	</div>
{/block}
