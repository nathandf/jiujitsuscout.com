<!DOCTYPE html>
<html>
	<head>
		{include file="includes/head/account-manager-head.tpl"}
	 <link type="text/css" rel="stylesheet" href="{$HOME}css/partner-lead.css">
	</head>
	<body>
		{include file="includes/navigation/business-manager-login-menu.tpl"}
	    {include file="includes/navigation/business-manager-menu.tpl"}
		<div class="con-cnt-xlrg first inned-pad-med">
			<a class="btn btn-inline bg-deep-blue text-med first" href="{$HOME}account-manager/business/group/{$group->id}/">< Group Manager</a>
			{if !empty($error_messages.edit_group)}
				{foreach from=$error_messages.edit_group item=message}
					<div class="con-message-failure mat-hov cursor-pt --c-hide">
						<p class="user-message-body">{$message}</p>
					</div>
				{/foreach}
			{/if}
			<div class="clear push-t-med"></div>
			<form method="post" action="">
				<input type="hidden" name="token" value="{$csrf_token}">
				<input type="hidden" name="update_group" value="{$csrf_token}">
				<label class="text-sml push-t-med">Group name</label><br>
				<input type="text" class="inp field-sml" name="name" value="{$group->name}">
				<div class="clear push-t-med"></div>
				<label class="text-sml">Description</label><br>
				<textarea type="text" style="text-indent: 0px; padding: 8px;" class="inp field-med" name="description" placeholder="Description">{$group->description}</textarea>
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
  </body>
</html>
