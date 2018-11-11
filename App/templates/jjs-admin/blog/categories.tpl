{extends file="layouts/core.tpl"}

{block name="head"}
	{include file="includes/head/main-head.tpl"}
	<link rel="stylesheet" href="{$HOME}public/css/article-builder.css">
	<meta charset="UTF-8">
	<meta name="google" content="notranslate">
	<meta http-equiv="Content-Language" content="en">
{/block}

{block name="body"}
	{include file="includes/navigation/admin-menu.tpl"}
	{include file="includes/widgets/primary-image-picker.tpl"}
	<div class="con-cnt-xlrg inner-pad-med push-t-med">
		<p class="text-lrg-heavy push-b-med"><a class="link cursor-pt tc-deep-blue" href="{$HOME}jjs-admin/blogs">Blogs</a> > <a class="link cursor-pt tc-deep-blue" href="{$HOME}jjs-admin/blog/{$blog->id}/">{$blog->name}</a> > Categories</p>
		{include file="includes/navigation/blog-admin-menu.tpl"}
	</div>
	<div class="con-cnt-xlrg inner-pad-med push-t-med push-b-med bg-white" style="border: 2px solid #CCC;">
		{if !empty($error_messages.new_category)}
			{foreach from=$error_messages.new_category item=message}
				<div class="con-message-failure mat-hov cursor-pt --c-hide">
					<p class="user-message-body">{$message}</p>
				</div>
			{/foreach}
		{/if}
		{foreach from=$blogCategories item=blogCategory name=blogCategoryLoop}
			{if $smarty.foreach.blogCategoryLoop.iteration == 1}
			<p>Categories:</p>
			{/if}
			<p style="display: inline-block" class="text-med-heavy">{$blogCategory->name}{if $blogCategories|@count > 1 && !$smarty.foreach.blogCategoryLoop.last}, {/if}</p>
		{foreachelse}
		<p class="push-b-med">No categories have been created yet</p>
		{/foreach}
		<div class="clear push-t-med"></div>
		<label>Create a new catetgory</label>
		<form method="post" action="">
			<input type="hidden" name="token" value="{$csrf_token}">
			<input type="hidden" name="new-category" value="{$csrf_token}">
			<input id="primary_image_id" type="hidden" name="image_id" value="">
			<input type="text" name="name" class="field-saas">
			<div class="clear push-t-med"></div>
			<label class="" for="title">Title</label>
			<div class="clear"></div>
			<input id="title" type="text" name="title" class="field-saas">
			<div class="clear push-t-med"></div>
			<label id="description" class="" for="description">Description</label>
			<div class="clear"></div>
			<textarea type="text" name="description" class="field-saas description"></textarea>
			<div class="clear"></div>
			<div class="clear col-100 push-t-med push-b-med" style="border-top: 1px solid #CCC;"></div>
			<label class="text-med">Primary Image</label>
			<div class="clear"></div>
			<img id="primary_image_display" style="width:280px;" src="http://placehold.it/550x270&text=No+Attachment!"/>
			<div class="clear"></div>
			<button type="button" class="btn btn-inline" id="choose-primary-image">Choose Image</button>
			<div class="clear col-100 push-b-med push-t-sml" style="border-top: 1px solid #CCC;"></div>
			<button class="btn btn-inline bg-deep-blue tc-white push-t-med">Create Category +</button>
		</form>
	</div>
{/block}

{block name="footer"}{/block}
