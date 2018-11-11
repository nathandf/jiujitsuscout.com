{extends file="layouts/core.tpl"}

{block name="head"}
	<title>{$blog->title} | {$blog->name}</title>
	<meta name="description" content="{$blog->description}">
	<link href="https://fonts.googleapis.com/css?family=Merriweather" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Raleway:800" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Josefin+Slab" rel="stylesheet">
	<link rel="stylesheet" href="{$HOME}public/css/article.css">
{/block}

{block name="body"}
	{include file="includes/navigation/blog-menu.tpl"}
	<div class="col-100 bg-white inner-pad-med-plus">
		<h1 class="taxon">{$blog->name}</h1>
		<img class="taxon-image push-t-med" src="{$HOME}public/img/uploads/{$blog->image->filename}" alt="{$blog->image->alt}">
		<h2 class="taxon-title push-t-med">{$blog->title}</h2>
		<p class="taxon-description push-t-med">{$blog->description}</p>
		<div class="col-100 push-t-med" style="border-top: 1px solid #CCCCCC;"></div>
		<h2 class="taxon-title push-t-med">Latest Articles</h2>
		{foreach from=$articles item=article}
			{include file="includes/snippets/article-snippet.tpl"}
		{/foreach}
		<div class="clear"></div>
	</div>
	<div class="clear"></div>
{/block}

{block name="footer"}
	{include file='includes/footer.tpl'}
{/block}
