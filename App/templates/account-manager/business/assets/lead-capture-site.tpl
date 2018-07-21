<!DOCTYPE html>
<html>
	<head>
		{include file="includes/head/account-manager-head.tpl"}
		<link rel="stylesheet" type="text/css" href="{$HOME}public/css/partner-settings.css"/>
		<script src="{$HOME}{$JS_SCRIPTS}site-slug-updater.js" type="text/javascript"></script>
	</head>
	<body>
		{include file="includes/navigation/business-manager-login-menu.tpl"}
	    {include file="includes/navigation/business-manager-menu.tpl"}
		<div class="con-cnt-xxlrg inner-box settings-box first">
			{include file="includes/navigation/business-assets-menu.tpl"}
			<div class="con-cnt-xlrg inner-pad-med">
				<h2 class="first last">Site Slug</h2>
				<p class="">Change the URL of your lead generation site. Create a unique URL Slug!</p>
				{if !empty($error_messages.update_site_slug)}
					{foreach from=$error_messages.update_site_slug item=message}
						<div class="con-message-failure mat-hov cursor-pt --c-hide">
							<p class="user-message-body">{$message}</p>
						</div>
					{/foreach}
				{/if}
				<form id="site-slug-form" action="" method="post">
					<input type="hidden" name="token" value="{$csrf_token}">
					<input id="input-slug" type="text" class="inp first field-sml" name="site_slug" placeholder="Site slug" name="title" value="{$business->site_slug}">
					<p class="text-sml">https://www.jiujitsuscout.com/martial-arts-gyms/<b id="slug">{$business->site_slug}</b>/</p>
				  	<div class="clear"></div>
					<input type="submit" form="site-slug-form" class="btn first" name="update_site_slug" value="Update Site Slug">
				</form>
				<div class="hr"></div>
				<h2>Message to your customers</h2>
				<div class="clear first last"></div>
				{if !empty($error_messages.update_site_message)}
					{foreach from=$error_messages.update_site_message item=message}
						<div class="con-message-failure mat-hov cursor-pt --c-hide">
							<p class="user-message-body">{$message}</p>
						</div>
					{/foreach}
				{/if}
				<form id="message" action="" method="post">
					<input type="hidden" name="token" value="{$csrf_token}">
					<input type="text" class="inp field-med" placeholder="Title" name="title" value="{$business->title}">
					<div class="first"></div>
					<textarea class="textbox textbox-lrg" placeholder="Your unique message here" name="message">{$business->message}</textarea>
					<div class="clear"></div>
					<input type="submit" form="message" class="btn" name="update_message" value="Update Message">
				</form>
			</div>
			<div class="clear"></div>
		</div>
		<div class="clear"></div>
	</body>
</html>
