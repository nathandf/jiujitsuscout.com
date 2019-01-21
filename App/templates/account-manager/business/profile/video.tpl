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
			{include file="includes/snippets/flash-messages.tpl"}
			{include file="includes/widgets/primary-video-picker.tpl"}
			{if !empty($videos)}
				<button class="btn btn-inline bg-deep-blue" id="choose-primary-video">Choose a video</button>
			{else}
				<p class="text-med">No videos have been uploaded. <a class="link tc-deep-blue" href="{$HOME}account-manager/business/assets/videos">Upload a video</a></p>
			{/if}
			<div class="clear hr-sml push-t-med"></div>
			{if !is_null($video)}
				<h3 class="push-t-med push-b-med">Current profile video</h3>
				<p class="text-med-heavy">{$video->name|default:"Unnamed"}</p>
				<p style="max-width: 80ch;" class="text-sml">{$video->description|default:"None</i>"}</p>
				{include file="includes/snippets/video.tpl"}
			{else}
				{if !empty($videos)}
				<p class="text-med">No primary video has been chosen</p>
				{/if}
			{/if}
		</div>
		<div class="clear"></div>
	</div>
	<div class="clear"></div>
{/block}
