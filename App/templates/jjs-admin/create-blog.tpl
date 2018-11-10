{extends file="layouts/core.tpl"}

{block name="head"}
	{include file="includes/head/main-head.tpl"}
{/block}

{block name="body"}
	{include file="includes/navigation/admin-menu.tpl"}
	{include file="includes/widgets/primary-image-picker.tpl"}
	<div class="con-cnt-xxlrg inner-pad-med">
		<div class="encapsulation-cnt-bare bg-white add-form push-t-med">
			<p class="encap-header bg-green tc-white">Create Blog</p>
			{if !empty($error_messages.create_blog)}
				{foreach from=$error_messages.create_blog item=message}
					<div class="con-message-failure mat-hov cursor-pt --c-hide">
						<p class="user-message-body">{$message}</p>
					</div>
				{/foreach}
			{/if}

			<form class="first" id="add-business" method="post" action="">
				<input type="hidden" name="token" value="{$csrf_token}">
				<input type="hidden" name="create" value="{$csrf_token}">
				<input id="primary_image_id" type="hidden" name="image_id" value="" required="required">
				<label>Blog Name</label>
				<div class="clear"></div>
				<input type="text" class="inp field-med" name="name" value="">
				<div class="clear push-t-med"></div>
				<label>Url</label>
				<div class="clear"></div>
				<input type="text" class="inp field-med" name="url" value="">
				<div class="clear push-t-med"></div>
				<label>Title</label>
				<div class="clear"></div>
				<input type="text" class="inp field-med" name="title" value="">
				<div class="clear push-t-med"></div>
				<label>Description</label>
				<div class="clear"></div>
				<textarea type="text" class="inp field-med" name="description"></textarea>
				<div class="clear"></div>
				<div class="clear col-100 push-t-med push-b-med" style="border-top: 1px solid #CCC;"></div>
				<label class="text-med">Primary Image</label>
				<div class="clear"></div>
				<img id="primary_image_display" style="width:280px;" src="http://placehold.it/550x270&text=No+Attachment!"/>
				<div class="clear"></div>
				<button type="button" class="btn btn-inline" id="choose-primary-image">Choose Image</button>
				<div class="clear col-100 push-b-med push-t-sml" style="border-top: 1px solid #CCC;"></div>
				<input type="submit" class="btn btn-cnt first" name="create" value="Create Blog +">
			</form>
		</div>
	</div>
{/block}

{block name="footer"}{/block}
