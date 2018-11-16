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
				<div style="box-sizing: border-box; padding: 10px;">
					<p class="push-r-sml{if $article->status == 'published'} tc-green{elseif $article->status == 'draft'} tc-deep-blue{else} tc-red{/if}">{$article->status|capitalize}</p>
					<p class="text-lrg-heavy floatleft">{$article->title|truncate:55:"..."}</p>
					<a href="{$HOME}jjs-admin/blog/{$blog->id}/article/{$article->id}/" class="btn btn-inline text-med-heavy bg-green floatright">Edit</a>
					<a href="{$HOME}jjs-admin/blog/{$blog->id}/article/{$article->id}/preview" class="btn btn-inline text-med-heavy bg-deep-blue floatright push-r-sml">Preview</a>
					<div class="clear"></div>
					<div class="col-100" style="border-top: 1px solid #CCCCCC;"></div>
				</div>
			{foreachelse}
			<p>No Articles have been written yet.</p>
			{/foreach}
		</div>
	</body>
</html>
