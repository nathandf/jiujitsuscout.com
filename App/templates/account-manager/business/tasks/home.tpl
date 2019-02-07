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
			<p class="text-sml">Track to-do items, get updates, send reminders.</p>
			<div class="hr-full"></div>
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
					<h3 class="push-l-sml">Pending Tasks</h3>
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
					<p class="text-med">{$task->due_date|date_format:"%A, %b %e %Y"} @ {$task->due_date|date_format:"%l:%M%p"}</p>
					<p class="text-med"><span class="text-med-heavy">Description: </span>{$task->message}</p>
					<div class="hr-full"></div>
					{foreach from=$task->comments item=comment name=comment_loop}
						{if $smarty.foreach.comment_loop.iteration == 1}<h4 class="push-b-sml push-t-med">Comments:</h4>{/if}
						<div class="task-comment mat-box-shadow push-b-med">
							<p class="text-sml-heavy">{$comment->commenter->getFullName()} — {$comment->created_at|date_format:"%A, %b %e %Y"} @ {$comment->created_at|date_format:"%l:%M%p"}</p>
							<p class="text-med push-t-med">{$comment->body}</p>
						</div>
					{/foreach}
					<div class="push-t-med">
						<h3>Leave a comment</h3>
					</div>
					<form method="post" action="">
						<input type="hidden" name="token" value="{$csrf_token}">
						<input type="hidden" name="task_id" value="{$task->id}">
						<textarea name="comment" class="inp textarea" required="required" style="width: 100%;"></textarea>
						<div class="clear"></div>
						<button type="submit" style="margin-bottom: 0px" class="btn btn-inline bg-good-green floatright"><i class="fa fa-commenting push-r-sml" aria-hidden="true"></i>Post Comment</button>
					</form>
					<div class="clear"></div>
					<div class="hr-full"></div>
					{foreach from=$task->assignees item=assignee name=assignee_loop}
						{if $smarty.foreach.assignee_loop.iteration == 1}<h4 class="push-b-sml">Assignees:</h4>{/if}
						<p class="text-med"><span class="text"></span>{$assignee->user->getFullName()}</p>
					{foreachelse}
						<p class="text-sml">No users have been assigned to this task</p>
					{/foreach}
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
