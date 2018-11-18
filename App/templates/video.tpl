{extends file="layouts/core.tpl"}

{block name="head"}
	<link rel="stylesheet" type="text/css" href="{$HOME}public/css/partner-settings.css"/>
{/block}

{block name="body"}
	<div class="con-cnt-xxlrg inner-box settings-box first">
		{if !empty($flash_messages)}
			{foreach from=$flash_messages item=message}
				<div class="con-message-success mat-hov cursor-pt --c-hide">
					<p class="user-message-body">{$message}</p>
				</div>
			{/foreach}
		{/if}
		<div class="con-cnt-xlrg first inner-pad-med">
			<h2 class="h2">Videos</h2>
			<div class="clear"></div>
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
			{foreach from=$videos item=video}
				{include file="includes/snippets/video.tpl"}
			{foreachelse}
			<p>No videos have been uploaded</p>
			{/foreach}
		</div>
		<div class="clear"></div>
	</div>
	<div class="clear"></div>
{/block}

{block name="footer"}
	{include file='includes/footer.tpl'}
{/block}
