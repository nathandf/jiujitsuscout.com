<!DOCTYPE html>
<html>
	<head>
		{include file='includes/head/main-head.tpl'}
		<link rel="stylesheet" type="text/css" href="{$HOME}public/css/partner-sign-in.css"/>
	</head>
	<body>
		{include file='includes/navigation/blank-menu.tpl'}
		<div class="con-cnt-med-plus bg-white border-std push-t-lrg push-b-lrg inner-pad-med">
			<h2 class="sub-title">Sign in</h2>
			<div class="">
				<img class="img-sml push-t-sml" style="margin: 0 auto; display: block;" src="{$HOME}public/img/jjslogoiconwhite.jpg" alt="">
				<div class="clear"></div>
			</div>
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
				<input class="inp inp-full push-t-med" type="text" name="email" value="{$inputs.sign_in.email|default:null}" placeholder="Email" />
				<div class="clear"></div>
				<input class="inp inp-full push-t-med" type="password" name="password" value="{$inputs.sign_in.password|default:null}" placeholder="Password" />
				<div class="clear"></div>
				<input class="button push-t-med" type="submit" value="Submit"/>
			</form>
		</div>
		{include file="includes/footer.tpl"}
	</body>
</html>
