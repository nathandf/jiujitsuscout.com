{extends file="layouts/business-manager-core.tpl"}

{block name="bm-head"}
	<link rel="stylesheet" href="{$HOME}public/css/partner-settings.css">
{/block}

{block name="bm-body"}
	{include file="includes/navigation/marketing-sub-menu.tpl"}
	<div class="con-cnt-xlrg push-t-med bg-white encapsulate">
		{include file="includes/navigation/business-manager-assets-inner-menu.tpl"}
		<div class="inner-pad-med">
			<h2 class="h2">Upload Image</h2>
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
				<div class="clear"></div>
				<div class="file-upload-container" style="display: none;">
					<p class="text-med">Tags:</p>
					{foreach from=$disciplines item=discipline}
						<input type="checkbox" id="disc{$discipline->id}" class="cursor-pt hidden-checkbox" name="discipline_tags[]" value="{$discipline->name}">
						<label class="cursor-pt text-sml discipline-tag-label push-t" for="disc{$discipline->id}">{$discipline->nice_name}</label>
					{/foreach}
					<input class="btn push-t-med file-upload-button" type="submit" value="Upload Image" name="upload_image" size="25" style="display: none;"/>
				</div>
				<div class="clear"></div>
			</form>
			<div class="clear"></div>
			<div class="push-t-lrg">
				{foreach from=$images item=image name=image_loop}
					<img style="max-height: 100px; border: 1px solid #CCC; border-radius: 3px;" src="{$HOME}public/img/uploads/{$image->filename}" alt="">
				{/foreach}
			</div>
		</div>
		<div class="clear"></div>
	</div>
	<div class="clear"></div>
{/block}
