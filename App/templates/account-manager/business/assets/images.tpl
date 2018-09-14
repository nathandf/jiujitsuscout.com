<!DOCTYPE html>
<html>
	<head>
		{include file="includes/head/account-manager-head.tpl"}
		<link rel="stylesheet" type="text/css" href="{$HOME}public/css/partner-settings.css"/>
	</head>
	<body>
		{include file="includes/navigation/business-manager-login-menu.tpl"}
	    {include file="includes/navigation/business-manager-menu.tpl"}
		<div class="con-cnt-xxlrg inner-pad-med settings-box push-t-med">
			{include file="includes/navigation/business-assets-menu.tpl"}
			<div class="con-cnt-xlrg first inner-pad-med">
				<h2 class="h2">Upload Image</h2>
				<!-- <img src="{$HOME}public/img/{if $business->logo_filename}uploads/{$business->logo_filename}{else}jjslogoiconblack.jpg{/if}" class="img-sml encapsulate bg-white first"/> -->
				<div class="clear push-t-lrg"></div>
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
					<input class="btn" type="submit" value="Upload Image" name="upload_image" size="25" />
					<div class="clear"></div>
				</form>
				<div class="clear"></div>
				{foreach from=$images item=image}
					<img style="max-width: 200px; border: 1px solid #CCC; border-radius: 3px;" src="{$HOME}public/img/uploads/{$image->filename}" alt="">
				{/foreach}
			</div>
			<div class="clear"></div>
		</div>
		<div class="clear"></div>
	</body>
</html>
