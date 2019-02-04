{extends file="layouts/account-manager-core.tpl"}

{block name="am-head"}
	{include file='includes/head/main-head.tpl'}
	<link rel="stylesheet" type="text/css" href="{$HOME}public/css/partner-sign-in.css"/>
{/block}

{block name="am-body"}
	{include file='includes/navigation/main-menu.tpl'}
	<div class="encapsulation-cnt">
		<h2 class="h2">Recover password</h2>
		{if !empty($error_messages.recover_password)}
			{foreach from=$error_messages.recover_password item=message}
					<div class="con-message-failure mat-hov cursor-pt --c-hide">
							<p class="user-message-body">{$message}</p>
					</div>
			{/foreach}
		{/if}
		<form method="post" action="">
			<input type="hidden" name="token" value="{$csrf_token}">
			<input type="hidden" name="forgot_password" value="{$csrf_token}">
			<input class="inp field-med push-t-med" type="text" name="email" placeholder="Email" />
			<div class="clear"></div>
			<input class="btn btn-cnt button-med push-t-med" type="submit" value="Recover Password"/>
		</form>
		<span><a class="link" href="{$HOME}account-manager/sign-in">Back to sign in</a></span>
	</div>
{/block}

{block name="am-footer"}
	{include file="includes/footer.tpl"}
{/block}
