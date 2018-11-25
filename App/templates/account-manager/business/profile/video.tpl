{extends file="layouts/business-manager-core.tpl"}

{block name="bm-head"}
	<link rel="stylesheet" type="text/css" href="{$HOME}public/css/partner-settings.css"/>
{/block}

{block name="bm-body"}
	{include file="includes/navigation/profile-sub-menu.tpl"}
	<div class="con-cnt-xxlrg push-t-med inner-pad-med">
		<div class="">
			<h2>Video</h2>
			<div class="clear push-t-med push-b-med"></div>
			{if !empty($error_messages.upload_video)}
				{foreach from=$error_messages.upload_video item=message}
					<div class="con-message-failure mat-hov cursor-pt --c-hide">
						<p class="user-message-body">{$message}</p>
					</div>
				{/foreach}
			{/if}
			<form action="" method="post" enctype="multipart/form-data">
				<input type="hidden" name="token" value="{$csrf_token}">
				<input class="btn-std" type="file" name="video" size="25"/>
				<input style="display: none;" class="btn file-upload-button" type="submit" value="Upload Photo" name="video" size="25" />
				<div class="clear"></div>
			</form>
			<div class="clear"></div>
			{if !is_null($video->id)}
			{include file="includes/snippets/video.tpl"}
			{else}
			<p>No videos have been uploaded</p>
			{/if}
		</div>
		<div class="clear"></div>
	</div>
	<div class="clear"></div>
{/block}
