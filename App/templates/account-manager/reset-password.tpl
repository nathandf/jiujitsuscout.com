{extends file="layouts/account-manager-core.tpl"}

{block name="am-head"}
	{include file='includes/head/main-head.tpl'}
	<link rel="stylesheet" type="text/css" href="{$HOME}public/css/partner-sign-in.css"/>
{/block}

{block name="am-body"}
	{include file='includes/navigation/main-menu.tpl'}
	<div class="encapsulation-cnt">
		{if !empty($error_messages.reset_password)}
			{foreach from=$error_messages.reset_password item=message}
				<div class="con-message-failure mat-hov cursor-pt --c-hide">
					<p class="user-message-body">{$message}</p>
				</div>
			{/foreach}
		{/if}
		<p class="form-title">Reset Password</p>
		<form action="" method="get" id="submit-form" >
			<input type="hidden" name="reset_token" value="{$reset_token}">
			<input type="hidden" name="reset_password" value="{$csrf_token}">
			<input type="hidden" name="token" value="{$csrf_token}">
			<input type="hidden" name="email" value="{$user->email}">
			<div class="clear"></div>
			<input type="password" class="inp field-med" id="password" name="password" placeholder="New Password" required="required"/>
			<div class="clear"></div>
			<input type="password" class="inp field-med" id="confirm_password" name="confirm_password" placeholder="Confirm Password" required="required"/>
			<input type="submit" class="btn btn-cnt button-med push-t-med" value="Reset Password"/>
		</form>
	</div>
{/block}

{block name="am-footer"}
	{include file="includes/footer.tpl"}
{/block}
