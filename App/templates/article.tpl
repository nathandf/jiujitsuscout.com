{extends file="layouts/core.tpl"}

{block name="head"}
	<title>{$article->meta_title}</title>
	<link rel="canonical" href="https://www.jiujitsuscout.com/{$blog->url}/{$article->slug}">
	<meta name="description" content="{$article->meta_description}">
	<link href="https://fonts.googleapis.com/css?family=Merriweather" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Raleway:800" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Josefin+Slab" rel="stylesheet">
	<link rel="stylesheet" href="{$HOME}public/css/article.css">
{/block}

{block name="body"}
	<div class="article-content con-cnt-xlrg bg-white push-t-lrg push-b-lrg inner-pad-med-plus">
		<h1>{$article->title}</h1>
		<div class="article-body">
			<p>{$article->body}</p>
		</div>
		<div class="clear"></div>
	</div>
	<div class="clear"></div>
{/block}

{block name="footer"}
	{include file='includes/footer.tpl'}
{/block}
