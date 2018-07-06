<!DOCTYPE html>
<html>
	<head>
		{include file="includes/head/account-manager-head.tpl"}
		<link rel="stylesheet" href="{$HOME}css/leads.css">
		<link rel="stylesheet" href="{$HOME}css/task.css">
		<script src="{$HOME}{$JS_SCRIPTS}task.js"></script>
	</head>
	<body>
		{include file="includes/navigation/business-manager-login-menu.tpl"}
		{include file="includes/navigation/business-manager-menu.tpl"}
		<div>
			<div class="clear"></div>
			<div class="con con-cnt-xxlrg first inner-pad-med">
				<h2 class="first">Tasks</h2>
				<p class="text-sml first">Remind yourself or staff members by email when something needs to completed</p>
				<div class="hr-sml"></div>
				<div class="clear"></div>
				<a href="{$HOME}account-manager/business/task/new" class="btn btn-inline mat-hov bg-deep-purple push-t-med"><span class="text-med">New Task <i class="fa fa-plus" aria-hidden="true"></i></span></a>
				<div class="clear"></div>
				{if !empty($flash_messages)}
					{foreach from=$flash_messages item=message}
						<div class="con-message-success mat-hov cursor-pt --c-hide">
							<p class="user-message-body">{$message}</p>
						</div>
					{/foreach}
				{/if}
				{if $tasks}
				<div class="task-group push-t-med">
					{foreach from=$tasks item=task name=task_loop}
					{if $smarty.foreach.task_loop.iteration <= 1}
					<div class="task-heading">
						<h3 class="push-l-sml">All Tasks</h3>
					</div>
					{/if}
					<div id="task-complete-form-{$smarty.foreach.task_loop.iteration}" class="task cursor-pt">
						<button id="task-drop-{$smarty.foreach.task_loop.iteration}" class="task-toggle-button --task-drop text-med floatright push-r-med cursor-pt"><i class="fa fa-bars" aria-hidden="true"></i></button>
						<form method="post" action="">
							<input type="hidden" name="token" value="{$csrf_token}">
							<input type="hidden" name="task_id" value="{$task->id}">
							<input type="hidden" name="complete_task" value="{$csrf_token}">
							<button id="task-id-{$smarty.foreach.task_loop.iteration}" class="--task-complete task-check floatleft push-r-sml push-l-sml cursor-pt"><i class="fa fa-check" aria-hidden="true"></i></button>
						</form>
						<p class="text-med"><a class="link tc-dark-grey" href="{$HOME}account-manager/business/task/{$task->id}/">{$task->title|capitalize|truncate:100:"..."}</a></p>
					</div>
					<div class="clear"></div>
					<div class="task-drop" id="task-drop-form-{$smarty.foreach.task_loop.iteration}" style="display: none;">
						<p class="text-med"><span class="text-med-heavy">Description: </span>{$task->message}</p>
						<p class="text-med"><span class="text-med-heavy">Due: </span>{$task->due_date|date_format:"%A, %b %e %Y"} @ {$task->due_date|date_format:"%l:%M%p"}</p>
						<p class="text-med"><span class="text-med-heavy">Assignee: </span>{$task->assignee_user->first_name}{if $task->assignee_user->last_name} {$task->assignee_user->last_name}{/if}</p>
						<form method="post" action="">
							<input type="hidden" name="token" value="{$csrf_token}">
							<input type="hidden" name="task_id" value="{$task->id}">
							<input type="hidden" name="send_reminder" value="{$csrf_token}">
							<button type="submit" style="margin-bottom: 0px" class="btn btn-inline push-t-med --c-send-confirm">Send Reminder <i class="fa fa-envelope" aria-hidden="true"></i></button>
						</form>
					</div>
					{/foreach}
				</div>
				{else}
				<p>You havent created any tasks yet</p>
				{/if}
				<div class="clear"></div>
			</div>
		</div><!-- end content -->
	</body>
</html>
