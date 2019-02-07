{extends file="layouts/business-manager-core.tpl"}

{block name="bm-head"}
	<link type="text/css" rel="stylesheet" href="{$HOME}public/css/partner-lead.css">
	<link type="text/css" rel="stylesheet" href="{$HOME}public/css/task.css">
	<script src="{$HOME}{$JS_SCRIPTS}task.js"></script>
{/block}

{block name="bm-body"}
	{include file="includes/navigation/business-manager-sub-menu.tpl"}
	{include file="includes/modals/reschedule.tpl"}
	<div class="con-cnt-xlrg push-t-med inner-pad-med">
		<a class="btn btn-inline bg-deep-purple text-med push-b-med push-b-lrg" href="{$HOME}account-manager/business/tasks/">< All Tasks</a>
		{include file="includes/snippets/flash-messages.tpl"}
		{if !empty($error_messages.update_task)}
			{foreach from=$error_messages.update_task item=message}
				<div class="con-message-failure mat-hov cursor-pt --c-hide">
					<p class="user-message-body">{$message}</p>
				</div>
			{/foreach}
		{/if}
		{if !empty($error_messages.reschedule_task)}
			{foreach from=$error_messages.reschedule_task item=message}
				<div class="con-message-failure mat-hov cursor-pt --c-hide">
					<p class="user-message-body">{$message}</p>
				</div>
			{/foreach}
		{/if}
		<div class="clear"></div>
		<button class="btn btn-inline bg-deep-blue reschedule-trigger">Reschedule Task</button>
		<p class="text-lrg-heavy">Due: {$task->due_date|date_format:"%A, %b %e %Y"} @ {$task->due_date|date_format:"%l:%M%p"}</p>
		<form method="post" action="">
			<input type="hidden" name="token" value="{$csrf_token}">
			<input type="hidden" name="update_task" value="{$csrf_token}">
			<div class="clear first"></div>
			<p class="text-sml">Task Name</p>
			<input type="text" name="title" value="{$task->title}" class="inp inp-med-plus-plus" placeholder="Task name">
			<div class="clear push-t-med"></div>
			<p class="text-sml">Task Description</p>
			<textarea name="message" class="inp textarea" id="" cols="30" rows="10" placeholder="Task description">{$task->message}</textarea>
			<div class="hr"></div>
			<div class="push-t-med">
				<p class="text-lrg-heavy">Choose Task Type:</p>
				<p class="text-sml">Select the category that best fits this task</p>
				<div class="clear push-t-sml"></div>
				<select class="inp inp-sml cursor-pt" name="task_type_id" id="action" required="required">
					{foreach from=$taskTypes item=taskType}
					<option name="task_type_id" value="{$taskType->id}">{$taskType->name}</option>
					{/foreach}
				</select>
			</div>
			<div class="push-t-med">
				<p class="text-lrg-heavy">Priority Level</p>
				<div class="clear push-t-sml"></div>
				<select class="inp inp-sml cursor-pt" name="priority" id="action" required="required">
					<option name="task_type_id" value="{$task->priority}" hidden="hidden" selected="selected">{$task->priority|capitalize}</option>
					<option name="task_type_id" value="low">Low</option>
					<option name="task_type_id" value="medium">Medium</option>
					<option name="task_type_id" value="high">High</option>
					<option name="task_type_id" value="critical">Critical</option>
				</select>
			</div>
			<div class="clear"></div>
			<div class="hr"></div>
			{if !empty($users)}
				<p class="text-lrg-heavy push-t-med">Assign to task:</p>
				<p class="text-sml">Choose the users responsible for this task</p>
				<div class="clear push-t-med push-b-med"></div>
				{foreach from=$users item=user name=user_loop}
				<input type="checkbox" id="users{$smarty.foreach.user_loop.index}" class="cursor-pt checkbox assignee-checkbox" name="user_ids[]" value="{$user->id}"{if $user->isset} checked="checked"{/if}>
				<label for="users{$smarty.foreach.user_loop.index}"><b>{$user->getFullName()}</b></label>
				<div class="clear"></div>
				{foreachelse}
			{/foreach}
			<div class="hr"></div>
			{/if}
			<div class="clear"></div>
			<input type="submit" class="btn btn-inline push-t-med task-submit push-r-med floatleft" value="Update">
		</form>
		<form method="post" action="">
			<input type="hidden" name="token" value="{$csrf_token}">
			<input type="hidden" name="trash" value="{$csrf_token}">
			<input type="hidden" name="task_id" value="{$task->id}">
			<button type="submit" class="btn btn-inline bg-red push-t-med floatright --c-trash"><i class="fa fa-trash" aria-hidden="true"></i> Delete Task</button>
		</form>
		<div class="clear"></div>
	</div>
{/block}
