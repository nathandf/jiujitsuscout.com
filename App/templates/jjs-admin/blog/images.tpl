{extends file="layouts/core.tpl"}

{block name="head"}
	{include file="includes/head/main-head.tpl"}
	<link rel="stylesheet" href="{$HOME}public/css/article-builder.css">
	<meta charset="UTF-8">
	<meta name="google" content="notranslate">
	<meta http-equiv="Content-Language" content="en">
	<script type="text/javascript" src="{$HOME}{$JS_SCRIPTS}image-upload.js"></script>
{/block}

{block name="body"}
	{include file="includes/navigation/admin-menu.tpl"}
	<div class="con-cnt-xlrg inner-pad-med push-t-med">
		<p class="text-lrg-heavy push-b-med"><a class="link cursor-pt tc-deep-blue" href="{$HOME}jjs-admin/blogs">Blogs</a> > <a class="link cursor-pt tc-deep-blue" href="{$HOME}jjs-admin/blog/{$blog->id}/">{$blog->name}</a> > Images</p>
		{include file="includes/navigation/blog-admin-menu.tpl"}
	</div>
	<div class="con-cnt-xlrg inner-pad-med push-t-med push-b-med bg-white" style="border: 2px solid #CCC;">
		{if !empty($error_messages.new_navigation_element)}
			{foreach from=$error_messages.new_navigation_element item=message}
				<div class="con-message-failure mat-hov cursor-pt --c-hide">
					<p class="user-message-body">{$message}</p>
				</div>
			{/foreach}
		{/if}
		{if !empty($error_messages.upload_image)}
			{foreach from=$error_messages.upload_image item=message}
				<div class="con-message-failure mat-hov cursor-pt --c-hide">
					<p class="user-message-body">{$message}</p>
				</div>
			{/foreach}
		{/if}
		<img id="image_display" style="width:280px;" src="http://placehold.it/550x270&text=No+Image+Selected"/>
		<form action="" method="post" enctype="multipart/form-data">
			<input type="hidden" name="token" value="{$csrf_token}">
			<input id="image_upload" class="btn-std" type="file" name="image" size="25"/>
			<input style="display: none;" class="btn file-upload-button" type="submit" value="Upload Photo" name="upload_image" size="25" />
			<div class="clear"></div>
		</form>
		<div class="clear"></div>
		<div class="push-t-lrg">
			{foreach from=$images item=image name=image_loop}
				<img style="max-height: 100px; border: 1px solid #CCC; border-radius: 3px;" src="{$HOME}public/img/uploads/{$image->filename}" alt="">
			{/foreach}
		</div>
	</div>
{/block}

{block name="footer"}{/block}
