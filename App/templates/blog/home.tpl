{extends file="layouts/core.tpl"}

{block name="head"}
	<title>{$blog->name}</title>
	<link rel="canonical" href="https://www.jiujitsuscout.com/{$blog->url}/">
	<meta name="description" content="">
	<link href="https://fonts.googleapis.com/css?family=Merriweather" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Raleway:800" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Josefin+Slab" rel="stylesheet">
	<link rel="stylesheet" href="{$HOME}public/css/article.css">
{/block}

{block name="body"}
	{include file="includes/navigation/blog-menu.tpl"}
	<div class="con-cnt-xlrg inner-pad-med-plus">
		<p>{$blog->name} | Home</p>
		{foreach from=$articles item=article}
			<a class="test-xlrg link" href="{$HOME}{$blog->url}/{$article->slug}">{$article->title}</a>
			<div class="clear"></div>
		{foreachelse}
		<p>No articles yet</p>
		{/foreach}
	</div>
	<div class="clear"></div>
{/block}

{block name="footer"}
	{include file='includes/footer.tpl'}
{/block}
