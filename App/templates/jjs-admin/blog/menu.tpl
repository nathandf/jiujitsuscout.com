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
		<form class="first" id="add-business" method="post" action="">
			<input type="hidden" name="token" value="{$csrf_token}">
			<input type="hidden" name="new-navigation-element" value="{$csrf_token}">
		</form>
	</div>
{/block}

{block name="footer"}{/block}
