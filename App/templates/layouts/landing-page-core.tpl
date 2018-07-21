{extends file="layouts/core.tpl"}

{if !isset($creator_active)}
{assign var="creator_active" value=false}
{assign var="creator_active_content_class" value=""}
{else}
{assign var="creator_active_content_class" value=" lp-creator-content"}
{/if}

{if !isset($template_view_active)}
{assign var="template_view_active" value=false}
{/if}

{if !isset($preview_active)}
{assign var="preview_active" value=false}
{/if}

{block name="head"}
		<meta name="robots" content="noindex, nofollow">
		<meta http-equiv="Content Type" content="text/html; charset=UTF-8" >
		<meta name ="viewport" content="width=device-width, initial-scale=1.0" >
		<meta http-equiv="content-language" content="en">
		<link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro" rel="stylesheet">
		<link href="https://fonts.googleapis.com/css?family=Noto+Sans" rel="stylesheet">
		<link href="https://fonts.googleapis.com/css?family=Roboto+Slab" rel="stylesheet">
		<link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
		<script src="https://use.fontawesome.com/e86aa14892.js"></script>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
		<link rel="stylesheet" href="{$HOME}public/css/main.css" type="text/css">
		<link rel="stylesheet" type="text/css" href="{$HOME}public/css/landing-page-main.css"/>
		<script src="{$HOME}{$JS_SCRIPTS}main.js"></script>
		<script src="{$HOME}{$JS_SCRIPTS}landing-page-main.js"></script>
		{if $creator_active}
		{assign var="creator_active_content_class" value=" lp-creator-content"}
		{else}
		{assign var="creator_active" value=false}
		{assign var="creator_active_content_class" value=""}
		{/if}
		{if $creator_active}
		<link rel="stylesheet" href="{$HOME}public/css/landing-page-creator.css" type="text/css">
		<script src="{$HOME}{$JS_SCRIPTS}landing-page-creator.js"></script>
		{/if}
		{block name="lp-head"}{/block}
{/block}
{block name="body"}
	{if $template_view_active || $preview_active}
		{include file="includes/navigation/business-manager-login-menu.tpl"}
		{include file="includes/navigation/business-manager-marketing-menu.tpl"}
	{/if}
	{include file="includes/forms/standard-form-hidden.tpl"}
	<div id="content" class="content{$creator_active_content_class}" style="background: {if $page->image_background}url({$HOME}img/uploads/{$page->image_background}){else}#FFF{/if}; background-attachment: fixed; background-repeat: no-repeat; background-size: 100%, 100%;">
		{if $template_view_active }
			<div class="con-cnt-lrg template-view-panel">
				<h2 class="title-wrapper">Choose a template</h2>
				<h3 class="title-wrapper">{$template->name}</h3>
				<a class="btn btn-inline floatleft" href="{$HOME}account-manager/business/landing-page/view-template?template_id={$previous_template_id}"> < Previous </a>
				<a class="btn btn-inline floatright" href="{$HOME}account-manager/business/landing-page/view-template?template_id={$next_template_id}"> Next > </a>
				<a class="btn btn-cnt-w-xsml bg-green" href="{$HOME}account-manager/business/landing-page/build?template_id={$current_template_id}">Build</a>
				<div class="clear"></div>
			</div>
		{/if}
		{block name="lp-body"}{/block}
	</div><!-- end content -->
	{if $creator_active}
	<div class="creator-form">
		<div class="input-container">
			{if !empty($error_messages.create_landing_page)}
				<div style="margin-top: 50px;"></div>
				{foreach from=$error_messages.create_landing_page item=message}
					<div class="con-message-failure mat-hov cursor-pt --c-hide">
						<p class="user-message-body">{$message}</p>
					</div>
				{/foreach}
			{/if}
			<form action="{$HOME}account-manager/business/landing-page/build?template_id={$template->id}" method="post" enctype="multipart/form-data">
				<div class="creator-button-container">
					<a class="floatleft btn btn-inline bg-deep-blue push-l" href="{$HOME}account-manager/business/landing-page/choose-template">< Back</a>
					<input type="submit" class="btn btn-inline floatright push-r creator-button" value="Finish">
				</div>
				<div class="sidebar">
					<input type="hidden" name="token" value="{$csrf_token}">
					<input type="hidden" name="create_landing_page" value="{$csrf_token}">
					<input type="hidden" name="template_id" value="{$template->id}">
					<div class="clear"></div>
					<label for=""><b>Landing Page Name</b></label>
					<div class="clear"></div>
					<input type="text" name="name" value="{$inputs.create_landing_page.name|default:null}" class="inp field-med">
					<div class="clear"></div>
					<label for=""><b>Landing Page Slug</b></label>
					<div class="clear"></div>
					<input type="text" name="slug" value="{$inputs.create_landing_page.slug|default:null}" class="inp field-med">
					<div class="clear"></div>
					<label for=""><b>Headline</b></label>
					<div class="clear"></div>
					<input type="text" name="headline" value="{$inputs.create_landing_page.headling|default:null}" id="input_headline" class="inp field-med" value="">
					<div class="clear"></div>
					<label for=""><b>Text A</b></label>
					<div class="clear"></div>
					<input type="text" name="text_a" value="{$inputs.create_landing_page.text_a|default:null}" id="input_text_a" class="inp field-med" value="">
					<div class="clear"></div>
					<label for=""><b>Text B</b></label>
					<div class="clear"></div>
					<input type="text" name="text_b" value="{$inputs.create_landing_page.text_b|default:null}" id="input_text_b" class="inp field-med" value="">
					<div class="clear"></div>
					<label for=""><b>Text C</b></label>
					<div class="clear"></div>
					<input type="text" name="text_c" value="{$inputs.create_landing_page.text_c|default:null}" id="input_text_c" class="inp field-med" value="">
					<div class="clear"></div>
					<label for=""><b>Call to Action</b></label>
					<div class="clear"></div>
					<input type="text" name="call_to_action" value="{$inputs.create_landing_page.call_to_action|default:null}" id="input_call_to_action" class="inp field-med" value="" require="required">
					<div class="clear"></div>
					<label for=""><b>Form text</b></label>
					<div class="clear"></div>
					<input type="text" name="text_form" value="{$inputs.create_landing_page.text_form|default:null}" id="input_text_form" class="inp field-med" value="">
					<div class="clear"></div>
					<label for=""><b>Form Call to Action</b></label>
					<div class="clear"></div>
					<input type="text" name="call_to_action_form" value="{$inputs.create_landing_page.call_to_action_form|default:null}" id="input_call_to_action_form" class="inp field-med" value="">
					<div class="clear"></div>
					<label for=""><b>Background Image</b></label>
					<div class="clear"></div>
					<img id="image_background" style="width:100%;" src="http://placehold.it/550x270&text=No+Attachment!"/>
					<label for="upload_image_background">Select File</label>
	        <input id="upload_image_background" name="image_background" class="first last" type="file">
					<div class="clear"></div>
					<label for=""><b>Image A</b></label>
					<div class="clear"></div>
					<img id="image_a_creator" style="width:100%;" src="http://placehold.it/550x270&text=No+Attachment!"/>
					<label for="upload_image_a">Select File</label>
	        <input id="upload_image_a" name="image_a" class="first last" type="file">
					<div class="clear"></div>
					<label for=""><b>Image B</b></label>
					<div class="clear"></div>
					<img id="image_b_creator" style="width:100%;" src="http://placehold.it/550x270&text=No+Attachment!"/>
					<label for="upload_image_b">Select File</label>
	        <input id="upload_image_b" name="image_b" class="first last" type="file">
					<div class="clear"></div>
					<label for=""><b>Image C</b></label>
					<div class="clear"></div>
					<img id="image_c_creator" style="width:100%;" src="http://placehold.it/550x270&text=No+Attachment!"/>
					<label for="upload_image_c">Select File</label>
	        <input id="upload_image_c" name="image_c" class="first last" type="file">
					<div class="clear last"></div>
				</div>
			</form>
		</div>
	</div>
	{/if}
{/block}
