{extends file="layouts/business-manager-core.tpl"}

{block name="bm-head"}
	<link type="text/css" rel="stylesheet" href="{$HOME}public/css/partner-lead.css">
	<link type="text/css" rel="stylesheet" href="{$HOME}public/css/task.css">
	<script src="{$HOME}{$JS_SCRIPTS}task.js"></script>
{/block}

{block name="bm-body"}
	{include file="includes/navigation/business-manager-sub-menu.tpl"}
	{include file="includes/modals/reschedule.tpl"}
	{include file="includes/modals/account-manager/choose-prospect.tpl"}
	{include file="includes/modals/account-manager/choose-member.tpl"}
	{include file="includes/modals/account-manager/actions-task.tpl"}
	<div class="con-cnt-xlrg push-t-med inner-pad-med">
		<a class="btn btn-inline bg-deep-purple text-med push-b-med" href="{$HOME}account-manager/business/tasks/">< All Tasks</a>
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
		<div class="hr-full"></div>
		<p class="text-lrg-heavy">Due: {$task->due_date|date_format:"%A, %b %e %Y"} @ {$task->due_date|date_format:"%l:%M%p"}</p>
		<button class="task-actions-modal-trigger btn btn-inline bg-deep-blue push-t-med"><i aria-hidden="true" class="fa fa-plus push-r-sml"></i>Actions</button>
		<div class="hr-full"></div>
		<form id="remove-prospect-form" method="post" action="">
			<input type="hidden" name="token" value="{$csrf_token}">
			<input type="hidden" name="remove_prospect" value="{$csrf_token}">
			<input id="remove-prospect-id" type="hidden" name="prospect_id" value="">
		</form>
		<form id="remove-member-form" method="post" action="">
			<input type="hidden" name="token" value="{$csrf_token}">
			<input type="hidden" name="remove_member" value="{$csrf_token}">
			<input id="remove-member-id" type="hidden" name="member_id" value="">
		</form>
		<form method="post" action="">
			<input type="hidden" name="token" value="{$csrf_token}">
			<input type="hidden" name="update_task" value="{$csrf_token}">
			<div class="clear first"></div>
			<p class="text-sml">Task Name</p>
			<input type="text" name="title" value="{$task->title}" class="inp inp-med-plus-plus" placeholder="Task name">
			<div class="clear push-t-med"></div>
			<p class="text-sml">Task Description</p>
			<textarea name="message" class="inp textarea" id="" cols="30" rows="10" placeholder="Task description">{$task->message}</textarea>
			<div class="clear"></div>
			{if count($taskProspects) > 0 || count($taskMembers) > 0}<div class="hr-full"></div>{/if}
			{foreach from=$taskProspects item=taskProspect name="tp_loop"}
			{if $smarty.foreach.tp_loop.iteration == 1}<p class="text-med-heavy">Leads</p>{/if}
			<div class="task-person-tag"><a class="link tc-deep-blue" href="{$HOME}account-manager/business/lead/{$taskProspect->prospect->id}/">{$taskProspect->prospect->getFullName()|truncate:35:"..."}</a><span data-id="{$taskProspect->prospect->id}" class="remove-prospect tc-red text-lrg-heavy push-l-sml cursor-pt"><i aria-hidden="true" class="fa fa-close"></i></span></div>
			{/foreach}
			{foreach from=$taskMembers item=taskMember name="tm_loop"}
			{if $smarty.foreach.tm_loop.iteration == 1}<p class="text-med-heavy push-t-sml">Members</p>{/if}
			<div class="task-person-tag"><a class="link tc-deep-blue" href="{$HOME}account-manager/business/member/{$taskMember->member->id}/">{$taskMember->member->getFullName()|truncate:35:"..."}</a><span data-id="{$taskMember->member->id}" class="remove-member tc-red text-lrg-heavy push-l-sml cursor-pt"><i aria-hidden="true" class="fa fa-close"></i></span></div>
			{/foreach}
			<div class="hr-full"></div>
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
			<button type="submit" class="btn btn-inline push-t-med task-submit --update-button push-r-med floatleft">Update</button>
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
