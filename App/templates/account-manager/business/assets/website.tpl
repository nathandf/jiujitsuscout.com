{extends file="layouts/business-manager-core.tpl"}

{block name="bm-head"}
	<link rel="stylesheet" type="text/css" href="{$HOME}public/css/partner-settings.css"/>
{/block}

{block name="bm-body"}
	{include file="includes/navigation/business-manager-sub-menu.tpl"}
	<div class="con-cnt-xxlrg push-t-med encapsulate bg-white">
		{include file="includes/navigation/business-manager-assets-inner-menu.tpl"}
		<div class="inner-pad-med">
			{if !empty($error_messages.website)}
				{foreach from=$error_messages.website item=message}
					<div class="con-message-failure mat-hov cursor-pt --c-hide">
						<p class="user-message-body">{$message}</p>
					</div>
				{/foreach}
			{/if}
			<div class="clear"></div>
			<h2 class="">Website</h2>
			<form action="" method="post">
				<input type="hidden" name="token" value="{$csrf_token}">
				<input type="text" name="website" class="inp field-med first" value="{$business->website}" placeholder="ex. https://www.yoursite.com">
				<div class="clear"></div>
				<input class="btn btn-inline push-t-med" type="submit" value="Update Website" name="update-pixel" />
				<div class="clear"></div>
			</form>
			<div class="clear"></div>
		</div>
		<div class="clear"></div>
	</div>
	<div class="clear"></div>
{/block}
