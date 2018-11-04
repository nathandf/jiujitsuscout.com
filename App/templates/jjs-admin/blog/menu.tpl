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
	<div class="con-cnt-xlrg inner-pad-med push-t-med">
		<p class="text-lrg-heavy push-b-med"><a class="link cursor-pt tc-deep-blue" href="{$HOME}jjs-admin/blogs">Blogs</a> > <a class="link cursor-pt tc-deep-blue" href="{$HOME}jjs-admin/blog/{$blog->id}/">{$blog->name}</a> > Menu</p>
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
		<p>Blog Navigation Element</p>
		<p class="text-sml">Create a new blog navigation element by choosing a blog category or creating one with a url slug and link text</p>

		<p class="push-t-med push-b-sml">Current Menu Elements:</p>
		<p class="text-sml">
			{foreach from=$blogNavigationElements item=$navElement name="nav_element_loop"}
			<span class="cursor-pt" style="border: 1px solid #CCC; border-radius: 3px; padding: 2px; box-sizing: border-box;">{$navElement->text}</span>
			{foreachelse}
			<span class="text-sml">No Nav Elements have been created yet</span>
			{/foreach}
		</p>
		<form method="post" action="">
			<input type="hidden" name="token" value="{$csrf_token}">
			<input type="hidden" name="new-navigation-element" value="{$csrf_token}">

			<div class="clear push-t-med"></div>
			<label id="text" class="" for="text">Link Text</label>
			<div class="clear"></div>
			<input type="text" name="text" class="field-saas">
			<div class="clear"></div>
			<div class="clear push-t-med"></div>
			<label class="" for="url">Url</label>
			<div class="clear"></div>
			<input id="url" type="text" name="url" class="field-saas">
			{if $blogCategories|@count > 0}
			<div class="hr"></div>
			<select class="inp field-med cursor-pt" name="blog_category_id" id="blog_categories">
				<option value="" selected="selected">--Choose Category--</option>
				{foreach from=$blogCategories item=category}
				<option value="{$category->id}">{$category->name}</option>
				{/foreach}
			</select>
			{else}
			<p class="push-t-med">No blog categories have been created yet</p>
			<a href="categories" class="link">Create a category</a>
			{/if}
			<div class="clear"></div>
			<button class="btn btn-inline bg-deep-blue tc-white push-t-med">Create Nav Item +</button>
		</form>
	</div>
{/block}

{block name="footer"}{/block}
