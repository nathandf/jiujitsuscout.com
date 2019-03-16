{extends file="layouts/business-profile.tpl"}
{block name="business-profile-body"}
	<div class="con-cnt-med-plus-plus push-t-med inner-pad-med border-std bg-white">
		{if !empty($error_messages.confirm_registration)}
			{foreach from=$error_messages.confirm_registration item=message}
				<div class="con-message-failure mat-hov cursor-pt --c-hide">
					<p class="user-message-body">{$message}</p>
				</div>
			{/foreach}
		{/if}
		<p class="title title-h3" style="margin-top: 0;">Confirm Registration with<br>{$business->business_name}</p>
		<p class="push-t-med">{$respondentRegistration->first_name}{if !is_null($respondentRegistration->last_name)} {$respondentRegistration->last_name}{/if}</p>
		<p class="push-t-sml">{$respondentRegistration->email}</p>
		<p class="push-t-sml">{$respondentRegistration->phone->national_number}</p>
		<form action="" method="post" >
			<input type="hidden" name="token" value="{$csrf_token}">
			<input type="hidden" name="confirm_registration" value="{$csrf_token}">
			<button type="submit" class="button push-t-med bg-good-green">Reserve your free class</button>
		</form>
	</div>
	<div class="clear"></div>
{/block}
