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
	<div class="alt-content" style="margin: 0px;">
		<div class="con-cnt-xlrg inner-pad-med">
			<h1 class="title">{$article->title}</h1>
			<p class="body push-t-lrg">{$article->body}</p>
		</div>
	</div>
{/block}

{block name="footer"}
	{include file='includes/footer.tpl'}
{/block}
