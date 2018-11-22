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
		<div class="con-cnt-xxlrg encapsulate settings-box first">
			{include file="includes/navigation/business-profile-menu.tpl"}
			<div class="con-cnt-xlrg inner-pad-med push-t-med">
				<h2>Message to your customers</h2>
				<div class="clear push-t-med push-b-med"></div>
				{if !empty($error_messages.update_site_message)}
					{foreach from=$error_messages.update_site_message item=message}
						<div class="con-message-failure mat-hov cursor-pt --c-hide">
							<p class="user-message-body">{$message}</p>
						</div>
					{/foreach}
				{/if}
				<form id="message" action="" method="post">
					<input type="hidden" name="token" value="{$csrf_token}">
					<textarea class="inp field-med-plus-plus-tall" style="padding: 10px; text-indent: 0;" placeholder="Your unique message here" name="message">{$business->message|default:null}</textarea>
					<div class="clear"></div>
					<input type="submit" form="message" class="btn" name="update_message" value="Update Message">
				</form>
			</div>
			<div class="clear"></div>
		</div>
		<div class="clear"></div>
	</body>
</html>
