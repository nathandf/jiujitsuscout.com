{extends file="layouts/core.tpl"}

{block name="head"}
	{include file="includes/head/main-head.tpl"}
	<link rel="stylesheet" href="{$HOME}public/css/article-builder.css">
	<meta charset="UTF-8">
	<meta name="google" content="notranslate">
	<meta http-equiv="Content-Language" content="en">
{/block}

{block name="body"}
	{include file="includes/navigation/admin-menu.tpl"}
	<div class="con-cnt-xlrg inner-pad-med push-t-med push-b-med bg-white" style="border: 2px solid #CCC;">
		<p class="text-lrg-heavy">Blog Name: <i>{$blog->name}</i></p>
		{if !empty($error_messages.create_article)}
			{foreach from=$error_messages.create_article item=message}
				<div class="con-message-failure mat-hov cursor-pt --c-hide">
					<p class="user-message-body">{$message}</p>
				</div>
			{/foreach}
		{/if}
		<form class="first" id="add-business" method="post" action="">
			<input type="hidden" name="token" value="{$csrf_token}">
			<input type="hidden" name="create_article" value="{$csrf_token}">
			<div class="clear col-100 push-t-med push-b-sml" style="border-top: 1px solid #CCC;"></div>
			<button type="submit" name="publish" class="btn btn-inline bg-green article-btn">Publish</button>
			<button type="submit" name="draft" class="btn btn-inline bg-deep-blue article-btn">Save draft</button>
			<div class="clear col-100 push-b-med push-t-sml" style="border-top: 1px solid #CCC;"></div>
			<label class="text-med">Article Title</label>
			<div class="clear"></div>
			<input type="text" class="article-builder-field mat-hov title" name="title" value="{$inputs.create_article.title|default:null}">
			<div class="clear col-100 push-t-med push-b-med" style="border-top: 1px solid #CCC;"></div>
			<label class="text-med">Slug</label>
			<div class="clear"></div>
			<input type="text" class="article-builder-field mat-hov title" name="slug" value="{$inputs.create_article.slug|default:null}">
			<div class="clear push-t-sml"></div>
			<label class="text-med">Meta Title</label>
			<div class="clear"></div>
			<input type="text" class="article-builder-field mat-hov title" name="meta_title" value="{$inputs.create_article.meta_title|default:null}">
			<div class="clear push-t-med"></div>
			<label class="text-med">Meta Description</label>
			<div class="clear"></div>
			<textarea class="article-builder-field mat-hov description" name="meta_description">{$inputs.create_article.meta_description|default:null}</textarea>
			<div class="clear col-100 push-t-med push-b-med" style="border-top: 1px solid #CCC;"></div>
			<label class="text-med">Article Body</label>
			<div class="clear"></div>
			<textarea class="article-builder-field mat-hov body" name="body">{$inputs.create_article.body|default:null}</textarea>
			<div class="clear col-100 push-t-med push-b-sml" style="border-top: 1px solid #CCC;"></div>
			<button type="submit" name="publish" class="btn btn-inline bg-green article-btn">Publish</button>
			<button type="submit" name="draft" class="btn btn-inline bg-deep-blue article-btn">Save draft</button>
		</form>
	</div>
{/block}

{block name="footer"}{/block}
