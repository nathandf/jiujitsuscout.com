{extends file="layouts/business-manager-core.tpl"}

{block name="bm-head"}
	<link rel="stylesheet" href="{$HOME}public/css/leads.css">
	<link rel="stylesheet" href="{$HOME}public/css/task.css">
	<script src="{$HOME}{$JS_SCRIPTS}task.js"></script>
{/block}

{block name="bm-body"}
	{include file="includes/navigation/business-manager-sub-menu.tpl"}
	{include file="includes/modals/new-task.tpl"}
	<div>
		<div class="clear"></div>
		<div class="con con-cnt-xlrg inner-pad-med">
			<h2 class="push-t-med">Tasks</h2>
			<p class="text-sml">Track to-do items, get updates, send reminders.</p>
			<div class="hr-full"></div>
			<div class="clear"></div>
			<button class="btn btn-inline mat-hov bg-deep-purple push-t-med --new-task-modal-trigger"><i class="fa fa-plus push-r-sml" aria-hidden="true"></i><span class="text-med">New Task</span></button>
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
				<a class="tc-dark-grey" href="{$HOME}account-manager/business/task/{$task->id}/" style="text-decoration: none;">
					<div id="task-complete-form-{$smarty.foreach.task_loop.iteration}" class="task cursor-pt">
						<button id="task-drop-{$smarty.foreach.task_loop.iteration}" class="task-toggle-button --task-drop --no-prop text-med floatright push-r-med cursor-pt"><i class="fa fa-bars" aria-hidden="true"></i></button>
						<form method="post" action="">
							<input type="hidden" name="token" value="{$csrf_token}">
							<input type="hidden" name="task_id" value="{$task->id}">
							<input type="hidden" name="complete_task" value="{$csrf_token}">
							<div class="floatleft task-priority-indicator {$task->priority}">&nbsp;</div>
							<button id="task-id-{$smarty.foreach.task_loop.iteration}" class="--task-complete task-check floatleft push-r-sml push-l-sml cursor-pt"><i class="fa fa-check" aria-hidden="true"></i></button>
						</form>
						<p class="text-med">{$task->title|capitalize|truncate:100:"..."}</p>
					</div>
				</a>
				<div class="clear"></div>
				<div class="task-drop" id="task-drop-form-{$smarty.foreach.task_loop.iteration}" style="display: none;">
					<p class="text-med">{$task->due_date|date_format:"%A, %b %e %Y"} @ {$task->due_date|date_format:"%l:%M%p"}</p>
					<p class="text-med"><span class="text-med-heavy">Description: </span>{$task->message}</p>
					{foreach from=$task->assignees item=assignee name=assignee_loop}
						{if $smarty.foreach.assignee_loop.iteration == 1}<p class="text-med-heavy push-t-med">Assignees:</p>{/if}
						<span class="text-sml">{$assignee->user->getFullName()}{if count($task->assignees) > 1 && $smarty.foreach.assignee_loop.iteration < count($task->assignees)}, {/if}</span>
					{foreachelse}
						<p class="text-sml">No users have been assigned to this task</p>
					{/foreach}
					<div class="clear"></div>
					{if count($task->taskProspects) > 0 || count($task->taskMembers) > 0}
					<div class="hr-full"></div>
						{foreach from=$task->taskProspects item=taskProspect name="tp_loop"}
						{if $smarty.foreach.tp_loop.iteration == 1}<p class="text-med-heavy">Leads</p>{/if}
						<div class="task-person-tag"><a class="link tc-deep-blue" href="{$HOME}account-manager/business/lead/{$taskProspect->prospect->id}/">{$taskProspect->prospect->getFullName()|truncate:35:"..."}</a></div>
						{/foreach}

						{foreach from=$task->taskMembers item=taskMember name="tm_loop"}
						{if $smarty.foreach.tm_loop.iteration == 1}<p class="text-med-heavy push-t-sml">Members</p>{/if}
						<div class="task-person-tag"><a class="link tc-deep-blue" href="{$HOME}account-manager/business/member/{$taskMember->member->id}/">{$taskMember->member->getFullName()|truncate:35:"..."}</a></div>
						{/foreach}
					{/if}
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
						<button type="submit" style="margin-bottom: 0px" class="btn btn-inline bg-good-green floatright">Comment</button>
					</form>
					<div class="clear"></div>
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
