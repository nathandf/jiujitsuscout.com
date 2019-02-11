{extends file="layouts/business-manager-core.tpl"}

{block name="bm-head"}
	<link rel="stylesheet" href="{$HOME}public/css/partner-settings.css">
{/block}

{block name="bm-body"}
	{include file="includes/navigation/profile-sub-menu.tpl"}
	<div class="con-cnt-xxlrg push-t-med inner-pad-med">
		<div class="">
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
				<div class="clear"></div>
				<div class="file-upload-container" style="display: none;">
					<p class="text-med">Add Tags:</p>
					{foreach from=$disciplines item=discipline}
						<input type="checkbox" id="disc{$discipline->id}" class="cursor-pt hidden-checkbox" name="discipline_tags[]" value="{$discipline->name}">
						<label class="cursor-pt text-sml discipline-tag-label push-t" for="disc{$discipline->id}">{$discipline->nice_name}</label>
					{/foreach}
					<input class="btn push-t-med file-upload-button" type="submit" value="Upload Image" name="upload_image" size="25" style="display: none;"/>
					<div class="clear"></div>
				</div>
			</form>
			<div class="clear"></div>
			{if $images|@count > 0}
				<div class="hr-sml push-t-med push-b-med"></div>
				{foreach from=$images item=image name=image_loop}
					<img style="max-height: 100px; border: 1px solid #CCC; border-radius: 3px;" src="{$HOME}public/img/uploads/{$image->filename}" alt="">
				{/foreach}
			{/if}
		</div>
		<div class="clear"></div>
	</div>
	<div class="clear"></div>
{/block}
