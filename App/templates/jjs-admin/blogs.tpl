{extends file="layouts/core.tpl"}

{block name="head"}
	{include file="includes/head/main-head.tpl"}
{/block}

{block name="body"}
	{include file="includes/navigation/admin-menu.tpl"}
	<div class="con-cnt-xxlrg inner-pad-med push-t-med">
		<a href="{$HOME}jjs-admin/create-blog" class="btn btn-inline bg-deep-blue tc-white">New Blog +</a>
		<div class="clear"></div>
		{foreach from=$blogs item=blog}
		<div class="clear push-t-med"></div>
		<a href="{$HOME}jjs-admin/blog/{$blog->id}/" class="text-xlrg-heavy link tc-deep-blue">{$blog->name}</a>
		{foreachelse}
		<div class="push-t-med"></div>
		No Blogs created yet
		{/foreach}
	</div>
{/block}

{block name="footer"}{/block}
