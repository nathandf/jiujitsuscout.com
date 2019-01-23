{extends file="layouts/business-manager-core.tpl"}

{block name="bm-head"}
	<link rel="stylesheet" type="text/css" href="{$HOME}public/css/partner-settings.css"/>
	<script src="{$HOME}{$JS_SCRIPTS}choose-logo.js"></script>
{/block}

{block name="bm-body"}
	{include file="includes/navigation/profile-sub-menu.tpl"}
	{include file="includes/widgets/insert-image-picker.tpl"}
	<div class="con-cnt-xxlrg inner-pad-med push-t-med">
		<div class="">
			<h2 class="h2">Logo</h2>
			{include file="includes/snippets/flash-messages.tpl"}
			<img id="image-display" src="{if !is_null($business->logo_image_id)}{$HOME}public/img/uploads/{$business->logo->filename}{else}http://placehold.it/300x300&text=Upload{/if}" class="img-sml encapsulate bg-white first"/>
			<div class="clear"></div>
			{if !empty($error_messages.upload_image)}
				{foreach from=$error_messages.upload_image item=message}
					<div class="con-message-failure mat-hov cursor-pt --c-hide">
						<p class="user-message-body">{$message}</p>
					</div>
				{/foreach}
			{/if}
			<button id="choose-image-button" class="btn btn-inline bg-deep-blue push-t-med">Choose Image</button>
			<form id="image-picker-form" action="" method="post" enctype="multipart/form-data">
				<input type="hidden" name="token" value="{$csrf_token}">
				<input type="hidden" name="image" value="{$csrf_token}">
				<input id="input-image-id" type="hidden" name="image_id" value="">
			</form>
			<div class="clear"></div>
		</div>
		<div class="clear"></div>
	</div>
	<div class="clear"></div>
{/block}
