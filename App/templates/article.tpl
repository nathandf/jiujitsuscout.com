{extends file="layouts/core.tpl"}

{block name="head"}
	<title>{$article->meta_title}</title>
	<link rel="canonical" href="https://www.jiujitsuscout.com/{$blog->url}/{$article->slug}">
	<meta name="description" content="{$article->meta_description}">
	<link href="https://fonts.googleapis.com/css?family=Merriweather" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Raleway:800" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Josefin+Slab" rel="stylesheet">
	<link rel="stylesheet" href="{$HOME}public/css/article.css">
	<script type="application/ld+json">
	{literal}
		{
			"@context": "http://schema.org",
			"@type": "BlogPosting",
			"mainEntityOfPage": {
				"@type": "WebPage",
				"@id": "https://jiujitsuscout.com/{/literal}{$blog->url}/{$article->slug}{literal}"
			},
			"headline": "{/literal}{$article->title}{literal}",
			"image": [
				"https://www.jiujitsuscout.com/public/img/jjslogoiconwhite.jpg"
			],
			"datePublished": "{/literal}{$article->created_at|date_format:'%a, %b %e %Y %l:%M%p'}{$article->created_at|date_format:"%a, %b %e %Y %l:%M%p"}{literal}",
			"dateModified": "{/literal}{$article->updated_at|date_format:'%a, %b %e %Y %l:%M%p'}{literal}",
			"author": {
				"@type": "Person",
				"name": "{/literal}{$article->author}{literal}"
			},
			"publisher": {
				"@type": "Organization",
				"name": "JiuJitsuScout",
				"logo": {
				  "@type": "ImageObject",
				  "text": "Find Martial Arts Near Me",
				  "url": "https://www.jiujitsuscout.com/public/img/jjslogoiconwhite.jpg"
				}
			},
			"description": "{/literal}{$article->meta_description}{literal}"
		}

	{/literal}
	</script>
{/block}

{block name="body"}
	{include file="includes/navigation/blog-menu.tpl"}
	<div class="article-content con-cnt-xlrg bg-white push-t-lrg push-b-lrg inner-pad-med-plus">
		{if $blogCategories|@count > 0}
			<span class="text-sml">
				{foreach from=$blogCategories item=blogCategory name=category_loop}
					<a class="link tc-deep-blue text-sml-heavy" href="{$HOME}{$blog->url}/category/{$blogCategory->url}/">{$blogCategory->name|capitalize}</a>{if !$smarty.foreach.category_loop.last} • {/if}
				{/foreach}
			</span>
			<div class="clear"></div>
		{/if}
		<h1>{$article->title}</h1>
		<span class="text-sml">Publish Date: <span>{$article->created_at|date_format:"%a, %b %e %Y %l:%M%p"}</span> | Author: <span>{$article->author}</span> | <span>JiuJitsuScout</span></span>
		{if isset($article->primary_image_id)}
			<img src="{$HOME}public/img/uploads/{$image->filename}" alt="{$image->alt}">
		{/if}
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
