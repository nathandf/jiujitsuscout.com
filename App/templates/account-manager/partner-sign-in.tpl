{extends file="layouts/account-manager-core.tpl"}

{block name="am-head"}
	{include file='includes/head/main-head.tpl'}
	<link rel="stylesheet" type="text/css" href="{$HOME}public/css/partner-sign-in.css"/>
{/block}

{block name="am-body"}
	{include file='includes/navigation/main-menu.tpl'}
	<div class="encapsulation-cnt">
		<h2 class="h2">Sign in</h2>
		<img class="img-sml push-t-sml" src="{$HOME}public/img/jjslogoiconwhite.jpg" alt="">
		<div class="clear"></div>
		<span class="text-med"> Not a partner yet? <br><a class="link text-med" href="{$HOME}partner/">Add your business</a></span>
		<div style="padding-left: 10px;">
			{if !empty($error_messages.sign_in)}
				{foreach from=$error_messages.sign_in item=message}
					<div class="con-message-failure mat-hov cursor-pt --c-hide">
							<p class="user-message-body">{$message}</p>
					</div>
				{/foreach}
			{/if}
		</div>
		<form action="" method="post">
			<input type="hidden" name="token" value="{$csrf_token}">
			<input type="hidden" name="sign_in" value="{$csrf_token}">
			<input class="inp field-med push-t-med" type="text" name="email" value="{$inputs.sign_in.email|default:null}" placeholder="Email" />
			<div class="clear"></div>
			<input class="inp field-med push-t-med" type="password" name="password" value="{$inputs.sign_in.password|default:null}" placeholder="Password" />
			<div class="clear"></div>
			<input class="btn btn-cnt button-med push-t-med" type="submit" value="Submit"/>
		</form>
		<span><a class="link" href="forgot-password">Forgot Password?</a></span>
	</div>
{/block}

{block name="am-footer"}
	{include file="includes/footer.tpl"}
{/block}
