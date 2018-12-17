{extends file="layouts/business-manager-core.tpl"}

{block name="bm-head"}
	<link rel="stylesheet" type="text/css" href="{$HOME}public/css/partner-settings.css"/>
{/block}

{block name="bm-body"}
	{include file="includes/navigation/marketing-sub-menu.tpl"}
	<div class="con-cnt-xxlrg push-t-med bg-white encapsulate">
		{include file="includes/navigation/business-manager-assets-inner-menu.tpl"}
		<div class="inner-pad-med">
			<h2>Video</h2>
			<div class="clear push-t-med push-b-med"></div>
			{if !empty($error_messages.upload_video)}
				{foreach from=$error_messages.upload_video item=message}
					<div class="con-message-failure mat-hov cursor-pt --c-hide">
						<p class="user-message-body">{$message}</p>
					</div>
				{/foreach}
			{/if}
			{include file="includes/snippets/flash-messages.tpl"}
			<form action="" method="post" enctype="multipart/form-data">
				<input type="hidden" name="token" value="{$csrf_token}">
				<input class="btn-std" type="file" name="video" size="25"/>
				<div class="clear"></div>
				<div style="display: none;" class="file-upload-field-container">
					<label for="">Video Title:</label>
					<div class="clear"></div>
					<input type="text" class="inp text-input" name="name">
					<div class="clear push-t-med"></div>
					<label for="">Description:</label>
					<div class="clear"></div>
					<textarea class="inp textarea" name="description"></textarea>
					<div class="clear"></div>
				</div>
				<input style="display: none;" class="btn file-upload-button" type="submit" value="Upload Photo" name="video" size="25" />
				<div class="clear"></div>
			</form>
			<div class="clear"></div>
			{if !is_null($video->id)}
			<h2 class="push-t-med">Current Video</h2>
			<div class="clear push-t-med"></div>
			<label class="text-med-heavy" for="">Video Title:</label>
			<p class="text-med">{$video->name|default:"<i>None</i>"}</p>
			<div class="clear push-t-med"></div>
			<label class="text-med-heavy" for="">Description:</label>
			<p style="max-width: 80ch;" class="text-med push-b-med">{$video->description|default:"<i>None</i>"}</p>
			{include file="includes/snippets/video.tpl"}
			{else}
			<p>No videos have been uploaded</p>
			{/if}
		</div>
		<div class="clear"></div>
	</div>
	<div class="clear"></div>
{/block}
