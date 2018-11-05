{extends file="layouts/core.tpl"}

{block name="head"}
	<title></title>
	<meta name="description" content="">
	<link href="https://fonts.googleapis.com/css?family=Merriweather" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Raleway:800" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Josefin+Slab" rel="stylesheet">
	<link rel="stylesheet" href="{$HOME}public/css/article.css">
{/block}

{block name="body"}
	{include file="includes/navigation/blog-menu.tpl"}
	<div class="con-cnt-xxlrg bg-white push-t-lrg push-b-lrg inner-pad-med-plus">
		<h1 class="taxon">{$blogCategory->name}</h1>
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
