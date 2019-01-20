{extends file="layouts/business-manager-core.tpl"}

{block name="bm-head"}
	<link type="text/css" rel="stylesheet" href="{$HOME}public/css/partner-lead.css">
{/block}

{block name="bm-body"}
	{include file="includes/navigation/communication-sub-menu.tpl"}
	<div class="con-cnt-xlrg first inner-pad-med">
		<a class="btn btn-inline bg-deep-blue text-med first" href="{$HOME}account-manager/business/group/{$group->id}/">< Group Manager</a>
		{if !empty($error_messages.edit_group)}
			{foreach from=$error_messages.edit_group item=message}
				<div class="con-message-failure mat-hov cursor-pt --c-hide">
					<p class="user-message-body">{$message}</p>
				</div>
			{/foreach}
		{/if}
		<div class="clear push-t-med"></div>
		{include file="includes/snippets/flash-messages.tpl"}
		<form method="post" action="">
			<input type="hidden" name="token" value="{$csrf_token}">
			<input type="hidden" name="update_group" value="{$csrf_token}">
			<label class="text-sml push-t-med">Group name</label><br>
			<input type="text" class="inp" name="name" value="{$group->name}">
			<div class="clear push-t-med"></div>
			<label class="text-sml">Description</label><br>
			<textarea type="text" class="inp textarea" name="description" placeholder="Description">{$group->description}</textarea>
			<div class="clear"></div>
			<input type="submit" class="btn bnt-inline push-t-med floatleft push-r" value="Update Group">
		</form>
		<form method="post" action="">
			<input type="hidden" name="token" value="{$csrf_token}">
			<input type="hidden" name="trash" value="{$csrf_token}">
			<input type="hidden" name="group_id" value="{$group->id}">
			<button type="submit" class="btn btn-inline bg-red push-t-med push-l floatleft --c-trash"><i class="fa fa-trash" aria-hidden="true"></i></button>
		</form>
		<div class="clear"></div>
	</div>
{/block}
