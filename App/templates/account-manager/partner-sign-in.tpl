<!DOCTYPE html>
<html>
	<head>
		{include file='includes/head/main-head.tpl'}
		<link rel="stylesheet" type="text/css" href="{$HOME}css/partner-sign-in.css"/>
	</head>
	<body>
		{include file='includes/navigation/main-menu.tpl'}
		<div>
			<div class="encapsulation-cnt">
				<p class="form-title">Sign in</p>
				<img class="img-sml" src="{$HOME}img/jjslogoiconwhite.jpg" alt="">
				<div class="clear"></div>
				<span class="text-med"> Not a partner yet? <br><a class="link text-med" href="{$HOME}partner/">Add your business</a></span>
				{if !empty($error_messages.sign_in)}
					{foreach from=$error_messages.sign_in item=message}
						<div class="con-message-failure mat-hov cursor-pt --c-hide">
								<p class="user-message-body">{$message}</p>
						</div>
					{/foreach}
				{/if}
				<form action="" method="post">
					<input type="hidden" name="token" value="{$csrf_token}">
					<input type="hidden" name="sign_in" value="{$csrf_token}">
					<input class="inp field-med first" type="text" name="email" value="{$inputs.sign_in.email|default:null}" placeholder="Email" />
					<div class="clear"></div>
					<input class="inp field-med" type="password" name="password" value="{$inputs.sign_in.password|default:null}" placeholder="Password" />
					<div class="clear"></div>
					<input class="btn btn-cnt button-med push-t-med" type="submit" value="Submit"/>
				</form>
				<span><a class="link" href="forgot-password">Forgot Password?</a></span>
			</div>
		</div>
		{include file="includes/footer.tpl"}
	</body>
</html>
