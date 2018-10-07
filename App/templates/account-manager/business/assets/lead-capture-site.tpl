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
			{include file="includes/navigation/business-assets-menu.tpl"}
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
				<div class="push-t-lrg">
					<h2>Frequently Asked Questions: </h2>
					{foreach from=$faqs item=faq}
						<div class="hr-sml"></div>
						<p class="text-lrg-heavy push-t-med"><span class="push-r">Q:</span>{$faq->text}</p>
						<form id="message" action="" method="post">
							<input type="hidden" name="token" value="{$csrf_token}">
							<input type="hidden" name="faq_id" value="{$faq->id}">
							{if !is_null( $faq->faqAnswer )}
								<input type="hidden" name="answered" value="true">
							{else}
								<input type="hidden" name="answered" value="false">
							{/if}
							<textarea class="inp field-med-plus-plus-tall push-t" style="padding: 10px; text-indent: 0;" placeholder="Your unique message here" name="faq_answer">{if !is_null($faq->faqAnswer)}{$faq->faqAnswer->text}{/if}</textarea>
							<div class="clear"></div>
							<input type="submit" class="btn" value="Submit Answer">
						</form>
					{/foreach}
				</div>
			</div>
			<div class="clear"></div>
		</div>
		<div class="clear"></div>
	</body>
</html>
