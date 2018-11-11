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
	{include file="includes/widgets/primary-image-picker.tpl"}
	{include file="includes/widgets/insert-image-picker.tpl"}
	<div class="con-cnt-xlrg inner-pad-med push-t-med">
		<p class="text-lrg-heavy push-b-med"><a class="link cursor-pt tc-deep-blue" href="{$HOME}jjs-admin/blogs">Blogs</a> > <a class="link cursor-pt tc-deep-blue" href="{$HOME}jjs-admin/blog/{$blog->id}/">{$blog->name}</a> > Article {$article->id}</p>
		{include file="includes/navigation/blog-admin-menu.tpl"}
	</div>
	<div class="con-cnt-xlrg inner-pad-med push-t-med push-b-med bg-white" style="border: 2px solid #CCC;">
		{if !empty($error_messages.create_article)}
			{foreach from=$error_messages.create_article item=message}
				<div class="con-message-failure mat-hov cursor-pt --c-hide">
					<p class="user-message-body">{$message}</p>
				</div>
			{/foreach}
		{/if}
		<p class="floatleft push-r-sml{if $article->status == 'published'} tc-green{elseif $article->status == 'draft'} tc-deep-blue{else} tc-red{/if}">{$article->status|capitalize}</p>
		<a href="{$HOME}jjs-admin/blog/{$blog->id}/article/{$article->id}/preview" class="btn btn-inline text-med-heavy bg-deep-blue floatright push-r-sml">Preview</a>
		<div class="clear"></div>
		<form class="first" method="post" action="">
			<input type="hidden" name="token" value="{$csrf_token}">
			<input type="hidden" name="create_article" value="{$csrf_token}">
			<input id="primary_image_id" type="hidden" name="primary_image_id" value="{$article->image->id}" required="required">
			<div class="clear col-100 push-t-med push-b-sml" style="border-top: 1px solid #CCC;"></div>
			<button type="submit" name="publish" value="1" class="btn btn-inline bg-green article-btn">Publish</button>
			<button type="submit" name="draft" value="1" class="btn btn-inline bg-deep-blue article-btn">Save draft</button>
			<div class="clear col-100 push-b-med push-t-sml" style="border-top: 1px solid #CCC;"></div>
			<label class="text-med">Article Title</label>
			<div class="clear"></div>
			<input id="input_title" type="text" class="article-builder-field title" name="title" value="{$article->title}">
			<div class="clear col-100 push-t-med push-b-med" style="border-top: 1px solid #CCC;"></div>
			<div class="clear"></div>
			<label class="text-med">Slug</label>
			<div class="clear"></div>
			<input id="input_slug" type="text" class="article-builder-field title" name="slug" value="{$article->slug}">
			<div class="clear"></div>
			<input type="checkbox" id="sluglock" class="checkbox" style="margin-right: 3px;"><i class="fa fa-lock" aria-hidden="true"></i>
			<div class="clear push-t-sml"></div>
			<label class="text-med">Meta Title</label>
			<div class="clear"></div>
			<p class="text-sml">character count: <span id="charCountTitle"></span></p>
			<input id="input_meta_title" type="text" class="article-builder-field title" name="meta_title" value="{$article->meta_title}">
			<div class="clear push-t-med"></div>
			<label class="text-med">Meta Description</label>
			<div class="clear"></div>
			<p class="text-sml">character count: <span id="charCountDescription"></span></p>
			<textarea id="input_meta_description" class="article-builder-field description" name="meta_description">{$article->meta_description}</textarea>
			<p class="push-t-med push-b-med text-med">Search Result Mockup:</p>
			<p class="sr-mockup-link" id="meta_title">{$article->meta_title}</p>
			<p class="sr-mockup-url">https://www.jiujitsuscout.com/{$blog->url}/<span id="slug">{$article->slug}</span></p>
			<p class="sr-mockup-description" id="meta_description">{$article->meta_description}</p>
			<div class="clear col-100 push-t-med push-b-med" style="border-top: 1px solid #CCC;"></div>
			<label class="text-med">Primary Image</label>
			<div class="clear"></div>
			<img id="primary_image_display" style="width:280px;" src="{if $article->image->filename != null}{$HOME}public/img/uploads/{$article->image->filename}{else}http://placehold.it/550x270&text=No+Attachment!{/if}"/>
			<div class="clear"></div>
			<button type="button" class="btn btn-inline" id="choose-primary-image">Choose Image</button>
			<div class="clear col-100 push-b-med push-t-sml" style="border-top: 1px solid #CCC;"></div>
			<div class="clear push-t-med">
				<p class="push-b-sml text-med">Categories:</p>
				{foreach from=$blogCategories item=blogCategory name=blogCategoryLoop}
					<div style="min-width: 140px; display: inline-block; padding: 5px; box-sizing: border-box; width: 25%;" class="floatleft">
						<table>
							<tr>
								<td><input id="cb{$blogCategory->id}" type="checkbox" name="blog_category_ids[]" value="{$blogCategory->id}" class="checkbox"{if $blogCategory->selected|default:null == true} checked="checked"{/if}></td>
								<td><label class="cursor-pt" for="cb{$blogCategory->id}">{$blogCategory->name}</label></td>
							</tr>
						</table>
					</div>
					{if $smarty.foreach.blogCategoryLoop.last || $smarty.foreach.blogCategoryLoop.iteration % 4 == 0}
					<div class="clear"></div>
					{/if}
				{foreachelse}
				<p class="push-b-med">No categories have been created yet</p>
				{/foreach}
			</div>
			<div class="clear col-100 push-t-med push-b-med" style="border-top: 1px solid #CCC;"></div>
			<label class="text-med">Article Body</label>
			<div class="clear"></div>
			<p class="text-sml">word count: <span id="wordCountBody"></span></p>
			<div class="clear"></div>
			<button id="bold" type="button" class="style-button cursor-pt"><i class="fa fa-bold" aria-hidden="true"></i></button>
			<button id="italic" type="button" class="style-button cursor-pt"><i class="fa fa-italic" aria-hidden="true"></i></button>
			<button id="underline" type="button" class="style-button cursor-pt"><i class="fa fa-underline" aria-hidden="true"></i></button>
			<button id="anchor" type="button" class="style-button cursor-pt"><i class="fa fa-link" aria-hidden="true"></i></button>
			<button id="header2" type="button" class="style-button cursor-pt">h2</button>
			<button id="header3" type="button" class="style-button cursor-pt">h3</button>
			<button id="choose-insert-image" type="button" class="style-button cursor-pt"><i class="fa fa-file-image-o" aria-hidden="true"></i></button>
			<div class="clear" style="margin-top: 3px;"></div>
			{include file="includes/widgets/anchor-widget.tpl"}
			<textarea id="article-body" class="article-builder-field body" name="body">{$article->body}</textarea>
			<div class="clear col-100 push-t-med push-b-sml" style="border-top: 1px solid #CCC;"></div>
			<button type="submit" name="publish" value="1" class="btn btn-inline bg-green article-btn">Publish</button>
			<button type="submit" name="draft" value="1" class="btn btn-inline bg-deep-blue article-btn">Save draft</button>
		</form>
	</div>
{/block}

{block name="footer"}{/block}
