<!DOCTYPE html>
<html>
	<head>
		{include file="includes/head/account-manager-head.tpl"}
		<link rel="stylesheet" type="text/css" href="{$HOME}css/partner-settings.css"/>
	</head>
	<body>
		{include file="includes/navigation/business-manager-login-menu.tpl"}
	    {include file="includes/navigation/business-manager-menu.tpl"}
		<div class="con-cnt-xxlrg inner-box settings-box first">
			{include file="includes/navigation/business-assets-menu.tpl"}
			<div class="con-cnt-xlrg first inner-pad-med">
				<h2 class="h2">Logo</h2>
				<img src="{$HOME}img/{if $business->logo_filename}uploads/{$business->logo_filename}{else}jjslogoiconblack.jpg{/if}" class="img-sml encapsulate bg-white first"/>
				<div class="clear"></div>
				{if !empty($error_messages.upload_image)}
					{foreach from=$error_messages.upload_image item=message}
						<div class="con-message-failure mat-hov cursor-pt --c-hide">
							<p class="user-message-body">{$message}</p>
						</div>
					{/foreach}
				{/if}
				<form action="" method="post" enctype="multipart/form-data">
					<input type="hidden" name="token" value="{$csrf_token}">
					<input class="btn-std" type="file" name="image" size="25"/>
					<input class="btn" type="submit" value="Upload Photo" name="upload_image" size="25" />
					<div class="clear"></div>
				</form>
				<div class="clear"></div>
			</div>
			<div class="clear"></div>
		</div>
		<div class="clear"></div>
	</body>
</html>
