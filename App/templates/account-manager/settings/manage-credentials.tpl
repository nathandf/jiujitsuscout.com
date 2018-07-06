<!DOCTYPE html>
<html>
	<head>
		{include file="includes/head/account-manager-head.tpl"}
		<link rel="stylesheet" type="text/css" href="{$HOME}css/partner-settings.css"/>
	</head>
	<body>
		{include file="includes/navigation/business-manager-login-menu.tpl"}
	    {include file="includes/navigation/account-manager-menu.tpl"}
		<div class="con-cnt-xxlrg inner-box first">
			{include file="includes/navigation/account-manager-settings-menu.tpl"}
			<div class="con-cnt-xlrg">
				<div class="inner-pad-med">
					<h2 class="h2 first last">Change Password</h2>
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
	          			<input type="text" class="inp field-med" id="email" name="email" value="{$inputs.update_password.email|default:null}" placeholder="Email" />
						<div class="clear push-t-med"></div>
						<input type="password" class="inp field-med" id="password" name="password" placeholder="New password" />
						<div class="clear push-t-med"></div>
						<input type="password" class="inp field-med" id="confim_password" name="confirm_password" placeholder="Confirm new password" />
						<div class="clear push-t-med"></div>
						<input type="submit" class="btn btn-inline" name="passwordReset"  value="Reset Password" color="#fff"/>
					</form>
				</div>
			</div>
		</div>
	</body>
</html>
