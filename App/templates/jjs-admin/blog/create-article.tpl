{extends file="layouts/core.tpl"}

{block name="head"}
	{include file="includes/head/main-head.tpl"}
	<link rel="stylesheet" href="{$HOME}public/css/article-builder.css">
	<meta charset="UTF-8">
	<meta name="google" content="notranslate">
	<meta http-equiv="Content-Language" content="en">
	<script src="{$HOME}{$JS_SCRIPTS}rangyinputs-jquery-src.js"></script>
	<script src="{$HOME}{$JS_SCRIPTS}rangyinputs-jquery.js"></script>
	<script src="{$HOME}{$JS_SCRIPTS}article-builder.js"></script>
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
			<button type="submit" name="publish" value="1" class="btn btn-inline bg-green article-btn">Publish</button>
			<button type="submit" name="draft" value="1" class="btn btn-inline bg-deep-blue article-btn">Save draft</button>
			<div class="clear col-100 push-b-med push-t-sml" style="border-top: 1px solid #CCC;"></div>
			<label class="text-med">Article Title</label>
			<div class="clear"></div>
			<input id="input_title" type="text" class="article-builder-field title" name="title" value="{$inputs.create_article.title|default:null}">
			<div class="clear col-100 push-t-med push-b-med" style="border-top: 1px solid #CCC;"></div>
			<label class="text-med">Slug</label>
			<div class="clear"></div>
			<input id="input_slug" type="text" class="article-builder-field title" name="slug" value="{$inputs.create_article.slug|default:null}">
			<div class="clear"></div>
			<input type="checkbox" id="sluglock" class="checkbox" style="margin-right: 3px;"><i class="fa fa-lock" aria-hidden="true"></i>
			<div class="clear push-t-sml"></div>
			<label class="text-med">Meta Title</label>
			<div class="clear"></div>
			<input id="input_meta_title" type="text" class="article-builder-field title" name="meta_title" value="{$inputs.create_article.meta_title|default:null}">
			<div class="clear push-t-med"></div>
			<label class="text-med">Meta Description</label>
			<div class="clear"></div>
			<textarea id="input_meta_description" class="article-builder-field description" name="meta_description">{$inputs.create_article.meta_description|default:null}</textarea>
			<p class="push-t-med push-b-sml">Search Result Mockup:</p>
			<div class="inner-pad-med sr-mockup">
				<p class="sr-mockup-link" id="meta_title"></p>
				<p class="sr-mockup-url">https://www.jiujitsuscout.com/{$blog->url}/<span id="slug"></span></p>
				<p class="sr-mockup-description" id="meta_description"></p>
			</div>
			<div class="clear col-100 push-t-med push-b-med" style="border-top: 1px solid #CCC;"></div>
			<label class="text-med">Article Body</label>
			<div class="clear"></div>
			<button id="bold" type="button" class="style-button cursor-pt"><i class="fa fa-bold" aria-hidden="true"></i></button>
			<button id="italic" type="button" class="style-button cursor-pt"><i class="fa fa-italic" aria-hidden="true"></i></button>
			<button id="underline" type="button" class="style-button cursor-pt"><i class="fa fa-underline" aria-hidden="true"></i></button>
			<button id="anchor" type="button" class="style-button cursor-pt"><i class="fa fa-anchor" aria-hidden="true"></i></button>
			<button id="header2" type="button" class="style-button cursor-pt">h2</button>
			<button id="header3" type="button" class="style-button cursor-pt">h3</button>
			<button type="button" class="style-button cursor-pt"><i class="fa fa-file-image-o" aria-hidden="true"></i></button>
			<div class="clear" style="margin-top: 3px;"></div>
			<textarea id="article-body" class="article-builder-field body" name="body">{$inputs.create_article.body|default:null}</textarea>
			<div class="clear col-100 push-t-med push-b-sml" style="border-top: 1px solid #CCC;"></div>
			<button type="submit" name="publish" value="1" class="btn btn-inline bg-green article-btn">Publish</button>
			<button type="submit" name="draft" value="1" class="btn btn-inline bg-deep-blue article-btn">Save draft</button>
		</form>
	</div>
{/block}

{block name="footer"}{/block}
