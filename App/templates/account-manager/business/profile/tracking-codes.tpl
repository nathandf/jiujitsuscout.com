{extends file="layouts/business-manager-core.tpl"}

{block name="bm-head"}
	<link rel="stylesheet" type="text/css" href="{$HOME}public/css/partner-settings.css"/>
{/block}

{block name="bm-body"}
	{include file="includes/navigation/profile-sub-menu.tpl"}
	<div class="con-cnt-xxlrg inner-pad-med push-t-med">
		<div class="">
			{if !empty($error_messages.facebook_pixel)}
				{foreach from=$error_messages.facebook_pixel item=message}
					<div class="con-message-failure mat-hov cursor-pt --c-hide">
						<p class="user-message-body">{$message}</p>
					</div>
				{/foreach}
			{/if}
			<div class="clear"></div>
			<h2 class="">Tracking your leads</h2>
			<p class="text-sml">Use your business's Facebook pixel to track the actions your leads take on your profile and landing pages.</p>
			<form action="" method="post">
				<input type="hidden" name="token" value="{$csrf_token}">
				<input type="text" name="facebook_pixel_id" class="inp field-med first" value="{$business->facebook_pixel_id}" placeholder="Facebook Pixel ID">
				<div class="clear"></div>
				<input class="btn btn-inline push-t-med" type="submit" value="Update Facebook Pixel ID" name="update-pixel" />
				<div class="clear"></div>
			</form>
			<div class="clear"></div>
		</div>
		<div class="clear"></div>
	</div>
	<div class="clear"></div>
{/block}
