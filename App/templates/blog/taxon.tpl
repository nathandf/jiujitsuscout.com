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
			<a style="text-decoration: none;" href="{$HOME}{$blog->url}/{$article->slug}">
				<div class="article-snippet-container mat-hov push-t-med inner-pad-med" style="border: 1px solid #EEE;">
					<img class="article-snippet-image floatleft" src="{$HOME}public/img/uploads/{$article->primary_image->filename}" alt="{$article->primary_image->alt}">
					<div class="article-snippet floatleft push-l-sml">
						<h2 class="article-snippet-title">{$article->title}</h2>
						<p class="article-snippet-description push-t-sml">{$article->meta_description}</p>
						<div class="clear"></div>
					</div>
					<div class="clear"></div>
				</div>
			</a>
		{/foreach}
		<div class="clear"></div>
	</div>
	<div class="clear"></div>
{/block}

{block name="footer"}
	{include file='includes/footer.tpl'}
{/block}
