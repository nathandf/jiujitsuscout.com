{extends file="layouts/business-manager-core.tpl"}

{block name="bm-head"}

{/block}

{block name="bm-body"}
	{include file="includes/navigation/business-manager-sub-menu.tpl"}
	<div>
		<div class="clear"></div>
		<div class="con con-cnt-xlrg push-t-med inner-pad-med">
			<a class="btn btn-inline bg-deep-purple text-med last" href="{$HOME}account-manager/business/tasks/">< All Tasks</a>
			<h2 class="h2 ta-left push-t-med push-b-lrg">Create a Task</h2>
			{if !empty($error_messages.create_task)}
				{foreach from=$error_messages.create_task item=message}
					<div class="con-message-failure mat-hov cursor-pt --c-hide">
						<p class="user-message-body">{$message}</p>
					</div>
				{/foreach}
			{/if}
			<form method="post" action="{$HOME}account-manager/business/task/new">
				<input type="hidden" name="token" value="{$csrf_token}">
				<input type="hidden" name="create_task" value="{$csrf_token}">
				<div class="clear first"></div>
				<p class="text-sml">Task Name</p>
				<input type="text" name="title" value="{$inputs.create_task.title|default:null}" class="inp inp-med-plus-plus" placeholder="Task name">
				<div class="clear push-t-med"></div>
				<p class="text-sml">Task Name</p>
				<textarea name="message" class="inp textarea" id="" cols="30" rows="10" placeholder="Task description">{$inputs.create_task.message|default:null}</textarea>
				<div class="clear"></div>
				<p class="text-lrg-heavy push-t-med">Assign to task:</p>
				<select class="first inp field-sml floatleft cursor-pt" name="user_id" id="action" required="required">
					{foreach from=$users item=user}
					<option name="user_id" value="{$user->id}" {if $current_user->id == $user->id}selected="selected"{/if}>{$user->first_name}{if $user->last_name} {$user->last_name}{/if}</option>
					{/foreach}
				</select>
				<div class="clear"></div>
				<p class="text-lrg-heavy push-t-med">Schedule Task:</p>
				<p class="text-sml push-t-sml">Date</p>
				{html_select_date class="inp field-sml cursor-pt" start_year='-1' end_year='+3'}
				<div class="clear"></div>
				<p class="text-sml push-t-sml">Time</p>
				{html_select_time class="inp field-sml cursor-pt" minute_interval=15 display_seconds=false use_24_hours=false}
				<div class="clear"></div>
				<input type="submit" class="btn btn-inline push-t-med" value="Create task">
			</form>
		</div>
	</div>
{/block}
