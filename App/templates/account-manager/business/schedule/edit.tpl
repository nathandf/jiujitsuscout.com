<!DOCTYPE html>
<html>
	<head>
		{include file="includes/head/account-manager-head.tpl"}
		<link type="text/css" rel="stylesheet" href="{$HOME}css/partner-lead.css">
		<link type="text/css" rel="stylesheet" href="{$HOME}css/schedule.css">
	</head>
	<body>
		{include file="includes/navigation/business-manager-login-menu.tpl"}
	    {include file="includes/navigation/business-manager-menu.tpl"}
		<div class="con-cnt-xxlrg first inner-pad-med">
			<a class="btn btn-inline bg-dark-creamsicle text-med first push-b-lrg" href="{$HOME}account-manager/business/schedule/{$schedule->id}/">< Schedule</a>
			{if !empty($flash_messages)}
				{foreach from=$flash_messages item=message}
					<div class="con-message-success mat-hov cursor-pt --c-hide">
						<p class="user-message-body">{$message}</p>
					</div>
				{/foreach}
			{/if}
			{if !empty($error_messages.update_schedule)}
				{foreach from=$error_messages.update_schedule item=message}
					<div class="con-message-failure mat-hov cursor-pt --c-hide">
						<p class="user-message-body">{$message}</p>
					</div>
				{/foreach}
			{/if}
			<div class="clear"></div>
			<form method="post" action="">
				<input type="hidden" name="token" value="{$csrf_token}">
				<input type="hidden" name="update_schedule" value="{$csrf_token}">
				<label class="text-sml">Schedule Name</label><br>
				<input type="text" class="schedule-name-input text-xlrg-heavy" name="name" value="{$schedule->name}">
				<div class="clear push-t-med"></div>
				<label class="text-sml">Description</label><br>
				<textarea type="text" style="text-indent: 0px; padding: 8px;" class="inp field-med" name="description" placeholder="Description">{$schedule->description}</textarea>
				<div class="clear"></div>
				<input type="submit" value="Update Schedule" class="btn btn-inline push-t-med floatleft">
			</form>
			<form method="post" action="">
				<input type="hidden" name="token" value="{$csrf_token}">
				<input type="hidden" name="delete_schedule" value="{$csrf_token}">
				<button type="submit" class="btn btn-inline bg-red push-t-med push-l floatleft --c-trash"><i class="fa fa-trash" aria-hidden="true"></i></button>
			</form>
			<div class="clear"></div>
		</div>
  </body>
</html>
