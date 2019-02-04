{extends file="layouts/business-manager-core.tpl"}

{block name="bm-head"}
	<link rel="stylesheet" href="{$HOME}public/css/leads.css">
	<link rel="stylesheet" href="{$HOME}public/css/task.css">
	<script src="{$HOME}{$JS_SCRIPTS}task.js"></script>
{/block}

{block name="bm-body"}
{include file="includes/navigation/business-manager-sub-menu.tpl"}
	<div>
		<div class="clear"></div>
		<div class="con con-cnt-xlrg inner-pad-med">
			<h2 class="push-t-med">Tasks</h2>
			<p class="text-sml">Remind yourself or staff members by email when something needs to completed</p>
			<div class="hr-sml"></div>
			<div class="clear"></div>
			<a href="{$HOME}account-manager/business/task/new" class="btn btn-inline mat-hov bg-deep-purple push-t-med"><i class="fa fa-plus push-r-sml" aria-hidden="true"></i><span class="text-med">New Task</span></a>
			<div class="clear push-t-med"></div>
			{if !empty($flash_messages)}
				{foreach from=$flash_messages item=message}
					<div class="con-message-success mat-hov cursor-pt --c-hide">
						<p class="user-message-body">{$message}</p>
					</div>
				{/foreach}
			{/if}
			{if $tasks}
			<div class="task-group mat-box-shadow">
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
						<button type="submit" style="margin-bottom: 0px" class="btn btn-inline push-t-med --c-send-confirm"><i class="fa fa-envelope push-r-sml" aria-hidden="true"></i>Send Reminder</button>
					</form>
				</div>
				{/foreach}
			</div>
			{else}
			<p>No tasks to show</p>
			{/if}
			<div class="clear"></div>
		</div>
	</div>
{/block}
