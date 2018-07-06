<!DOCTYPE html>
<html>
	<head>
		 {include file="includes/head/account-manager-head.tpl"}
		 <link rel="stylesheet" type="text/css" href="{$HOME}css/account-manager-main.css">
	</head>
	<body>
		{include file="includes/navigation/business-manager-login-menu.tpl"}
		{include file="includes/navigation/business-manager-menu.tpl"}
		<div>
			<div class="clear"></div>
			<div class="con con-cnt-xxlrg first inner-pad-med">
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
					<p><b>Task Name:</b></p>
					<input type="text" name="title" value="{$inputs.create_task.title|default:null}" class="inp field-sml" placeholder="Task name">
					<div class="clear first"></div>
					<b>Description: </b>
					<div class="clear"></div>
					<textarea style="text-indent: 0px; padding: 8px;" name="message" class="inp field-med" id="" cols="30" rows="10" placeholder="Task description">{$inputs.create_task.message|default:null}</textarea>
					<div class="clear"></div>
					<p class="text-lrg-heavy push-t-med">Assign to task:</p>
					<select class="first inp field-sml floatleft cursor-pt" name="user_id" id="action" required="required">
						{foreach from=$users item=user}
						<option name="user_id" value="{$user->id}" {if $current_user->id == $user->id}selected="selected"{/if}>{$user->first_name}{if $user->last_name} {$user->last_name}{/if}</option>
						{/foreach}
					</select>
					<div class="clear"></div>
					<p class="text-lrg-heavy push-t-med">Schedule Task:</p>
					<p class="text-lrg push-t">Date</p>
					{html_select_date class="inp field-xsml-plus cursor-pt first" start_year='-1' end_year='+3'}
					<div class="clear"></div>
					<p class="text-lrg push-t">Time</p>
					{html_select_time class="inp field-xsml cursor-pt first" minute_interval=15 display_seconds=false use_24_hours=false}
					<div class="clear"></div>
					<input type="submit" class="btn btn-inline push-t-med" value="Create task">
				</form>
			</div>
		</div><!-- end content -->
	</body>
</html>
