{extends file="layouts/business-manager-core.tpl"}

{block name="bm-head"}
	<link type="text/css" rel="stylesheet" href="{$HOME}public/css/partner-lead.css">
	<link type="text/css" rel="stylesheet" href="{$HOME}public/css/task.css">
{/block}

{block name="bm-body"}
{include file="includes/navigation/business-manager-sub-menu.tpl"}
	<div class="con-cnt-xlrg push-t-med inner-pad-med">
		<a class="btn btn-inline bg-deep-purple text-med push-b-med push-b-lrg" href="{$HOME}account-manager/business/tasks/">< All Tasks</a>
		{if !empty($flash_messages)}
			{foreach from=$flash_messages item=message}
				<div class="con-message-success mat-hov cursor-pt --c-hide">
					<p class="user-message-body">{$message}</p>
				</div>
			{/foreach}
		{/if}
		{if !empty($error_messages.update_task)}
			{foreach from=$error_messages.update_task item=message}
				<div class="con-message-failure mat-hov cursor-pt --c-hide">
					<p class="user-message-body">{$message}</p>
				</div>
			{/foreach}
		{/if}
		<div class="clear"></div>
		<form method="post" action="">
			<input type="hidden" name="token" value="{$csrf_token}">
			<input type="hidden" name="update_task" value="{$csrf_token}">
			<p class="text-sml">Task Name</p>
			<!-- class text-name-input-->
			<input type="text" class="inp inp-med-plus-plus" name="title" value="{$task->title}">
			<div class="clear push-t-med"></div>
			<p class="text-sml">Description</p>
			<textarea type="text" class="inp textarea" name="message" placeholder="Description">{$task->message}</textarea>
			<div class="clear"></div>
			<label class="text-sml">Assign task:</label>
			<div class="clear"></div>
			<select class="inp inp-sml floatleft cursor-pt" name="user_id" id="action" required="required">
				<option>-- Assigned User --</option>
				<option name="user_id" value="{$task->assignee_user->id}" selected="selected">{$task->assignee_user->first_name}{if $task->assignee_user->last_name} {$task->assignee_user->last_name}{/if}</option>
				<option>-- All Users --</option>
				{foreach from=$users item=user}
				<option name="user_id" value="{$user->id}">{$user->first_name}{if $user->last_name} {$user->last_name}{/if}</option>
				{/foreach}
			</select>
			<div class="clear"></div>
			<p class="text-lrg-heavy push-t-med">Schedule Task:</p>
			<p class="text-sml">Date</p>
			{html_select_date time="{$year}-{$month}-{$day}" class="inp field-sml cursor-pt" start_year='-1' end_year='+3'}
			<div class="clear push-t-sml"></div>
			<p class="text-sml">Time</p>
			{html_select_time time="{$year}-{$month}-{$day} {$hour}:{$minute}" class="inp field-sml cursor-pt" minute_interval=15 display_seconds=false use_24_hours=false}
			<div class="clear"></div>
			<input type="submit" class="btn bnt-inline first floatleft push-r" value="Update Task">
		</form>
		<form method="post" action="">
			<input type="hidden" name="token" value="{$csrf_token}">
			<input type="hidden" name="trash" value="{$csrf_token}">
			<input type="hidden" name="task_id" value="{$task->id}">
			<button type="submit" class="btn btn-inline bg-red first push-l floatleft --c-trash"><i class="fa fa-trash" aria-hidden="true"></i></button>
		</form>
		<div class="clear"></div>
	</div>
{/block}
