<!DOCTYPE html>
<html>
	<head>
		{include file="includes/head/admin-head.tpl"}
	</head>
	<body>
	    {include file="includes/navigation/admin-menu.tpl"}
		<div class="con-cnt-xlrg inner-pad-med push-t-med">
			<p class="text-lrg-heavy push-b-med"><a class="link cursor-pt tc-deep-blue" href="{$HOME}jjs-admin/blogs">Blogs</a> > <a class="link cursor-pt tc-deep-blue" href="{$HOME}jjs-admin/blog/{$blog->id}/">{$blog->name}</a></p>
			{include file="includes/navigation/blog-admin-menu.tpl"}
		</div>
		<div class="con-cnt-xlrg inner-pad-med push-t-med push-b-med bg-white" style="border: 2px solid #CCC;">
			<div class="clear"></div>
			{foreach from=$articles item=article}
			<a href="{$HOME}jjs-admin/blog/{$blog->id}/article/{$article->id}/" class="link text-lrg-heavy tc-green">{$article->title}</a>
			<div class="clear"></div>
			{foreachelse}
			<p>No Articles have been written yet.</p>
			{/foreach}
		</div>
	</body>
</html>
