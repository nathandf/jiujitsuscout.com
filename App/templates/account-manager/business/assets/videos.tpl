{extends file="layouts/business-manager-core.tpl"}

{block name="bm-head"}
	<link rel="stylesheet" type="text/css" href="{$HOME}public/css/partner-settings.css"/>
{/block}

{block name="bm-body"}
	{include file="includes/navigation/marketing-sub-menu.tpl"}
	<div class="con-cnt-xlrg push-t-med bg-white encapsulate">
		{include file="includes/navigation/business-manager-assets-inner-menu.tpl"}
		<div class="inner-pad-med">
			<h2>Videos</h2>
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
					<label class="text-sml" for="">Video Title:</label>
					<div class="clear"></div>
					<input type="text" class="inp text-input" name="name">
					<div class="clear push-t-med"></div>
					<label class="text-sml" for="">Description:</label>
					<div class="clear"></div>
					<textarea class="inp textarea" name="description"></textarea>
					<div class="clear"></div>
					<input id="primary-video-checkbox" type="checkbox" class="checkbox" name="primary">
					<label class="text-med" for="primary-video-checkbox">Make this the profile video for <b>{$business->business_name}<b>?</label>
				</div>
				<button style="display: none;" class="btn file-upload-button push-t-med" type="submit" name="video" value="1"><i aria-hidden="true" class="fa fa-upload push-r-sml"></i>Upload Video</button>
				<div class="clear"></div>
			</form>
			<div class="clear"></div>
			{foreach from=$videos item=video}
			<div class="hr-sml"></div>
			<p class="text-med-heavy">{$video->name|default:"Unnamed"}</p>
			<p style="max-width: 80ch;" class="text-sml">{$video->description|default:"No Description"}</p>
			{include file="includes/snippets/video.tpl"}
			{foreachelse}
			<p>No videos have been uploaded</p>
			{/foreach}
		</div>
		<div class="clear"></div>
	</div>
	<div class="clear"></div>
{/block}
