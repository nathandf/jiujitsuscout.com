<!DOCTYPE html>
<html>
	<head>
		{include file="includes/head/admin-head.tpl"}
	</head>
	<body>
	    {include file="includes/navigation/admin-menu.tpl"}
	    <div class="con-cnt-xxlrg inner-pad-med push-t-med">
			<a href="new-article" class="btn btn-inline bg-deep-blue tc-white">New Article +</a>
			<div class="clear push-b-med"></div>
			{foreach from=$articles item=article}
			<a href="{$HOME}jjs-admin/blog/{$blog->id}/article/{$article->id}/" class="link text-lrg-heavy tc-green">{$article->title}</a>
			<div class="clear"></div>
			{foreachelse}
			<p>No Articles have been written yet.</p>
			{/foreach}
		</div>
	</body>
</html>
