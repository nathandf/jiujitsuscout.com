{extends file="layouts/core.tpl"}

{block name="head"}
	{include file="includes/head/main-head.tpl"}
{/block}

{block name="body"}
	{include file="includes/navigation/admin-menu.tpl"}
	<div class="con-cnt-xxlrg inner-pad-med">
		<div class="encapsulation-cnt-bare bg-white add-form push-t-med">
			<p class="encap-header bg-deep-blue tc-white">Create Article</p>
			{if !empty($error_messages.create_blog)}
				{foreach from=$error_messages.add_business item=message}
					<div class="con-message-failure mat-hov cursor-pt --c-hide">
						<p class="user-message-body">{$message}</p>
					</div>
				{/foreach}
			{/if}
			<form class="first" id="add-business" method="post" action="">
				<input type="hidden" name="token" value="{$csrf_token}">
				<input type="hidden" name="create" value="{$csrf_token}">
				<label>Blog Name</label>
				<div class="clear"></div>
				<input type="text" class="inp field-med" name="name" value="">
				<div class="clear push-t-med"></div>
				<label>Url</label>
				<div class="clear"></div>
				<input type="text" class="inp field-med" name="url" value="">
				<div class="clear"></div>
				<input type="submit" class="btn btn-cnt first" name="create" value="Create Blog +">
			</form>
		</div>
	</div>
{/block}

{block name="footer"}{/block}
