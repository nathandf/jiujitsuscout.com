<!DOCTYPE html>
<html>
<head>
	{include file='includes/head/main-head.tpl'}
	<link rel="stylesheet" type="text/css" href="{$HOME}css/partner-sign-in.css"/>
</head>
<body>
	{include file='includes/navigation/main-menu.tpl'}
	<div>
		<div class="con-cnt-xlrg inner-pad-med">
			<h1 class="h1 title-wrapper push-t-lrg" style="text-align: left;">Invalid Token!</h1>
			<p class="text-lrg-heavy push-t-lrg">The token you attempted to use is either expired or does not exist.</p>
			<div class="clear push-t-med"></div>
			<a href="{$HOME}account-manager/sign-in" class="text-med link">Back to sign in</a>
		</div>
	</div>
</body>
</html>
