{extends file="layouts/business-manager-core.tpl"}

{block name="bm-head"}
	<link rel="stylesheet" type="text/css" href="{$HOME}public/css/partner-settings.css"/>
{/block}

{block name="bm-body"}
	{include file="includes/navigation/profile-sub-menu.tpl"}
	<div class="con-cnt-xxlrg inner-pad-med push-t-med">
		<div class="">
			<h2 class="h2">Logo</h2>
			<img src="{$HOME}public/img/{if $business->logo_filename}uploads/{$business->logo_filename}{else}jjslogoiconblack.jpg{/if}" class="img-sml encapsulate bg-white first"/>
			<div class="clear"></div>
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
				<input style="display: none;" class="btn file-upload-button" type="submit" value="Upload Photo" name="upload_image" size="25" />
				<div class="clear"></div>
			</form>
			<div class="clear"></div>
		</div>
		<div class="clear"></div>
	</div>
	<div class="clear"></div>
{/block}
